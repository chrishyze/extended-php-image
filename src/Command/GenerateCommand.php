<?php
/**
 * This file is part of extended-php.
 *
 * @author  chrishyze <chrishyze@gmail.com>
 * @link    https://github.com/chrishyze/extended-php
 * @license https://github.com/chrishyze/extended-php/blob/master/LICENSE
 */

declare(strict_types=1);

namespace ExtendedPhp\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

#[AsCommand(
    name: 'generate',
    description: 'Generate dockerfiles for Docker Hub publishing.',
    hidden: false,
    aliases: ['gen']
)]
class GenerateCommand extends Command
{
    protected string $projectDir;

    protected function configure(): void
    {
        $this->projectDir = dirname(__DIR__, 2);
        $fs = new Filesystem();
        if ($fs->exists($this->projectDir.'/dockerfile')) {
            $fs->remove($this->projectDir.'/dockerfile');
        }
        $fs->mkdir($this->projectDir.'/dockerfile', 0777);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln(['', 'Extended PHP Generator', '']);

        $platforms = ['linux/amd64', 'linux/arm64/v8', 'linux/arm/v7'];
        $excludeArmv7Tags = ['8.2-fpm', '8.2-cli', '8.1-fpm', '8.1-cli'];
        $extensions = [
            'bcmath',
            'event',
            'exif',
            'gd',
            'gnupg',
            'grpc',
            'imagick',
            'memcached',
            'mongodb',
            'mysqli',
            'opcache',
            'pcntl',
            'pdo_mysql',
            'pdo_pgsql',
            'pgsql',
            'protobuf',
            'redis',
            'sockets',
            'ssh2',
            'swoole',
            'xdebug',
            'zip',
            'zookeeper',
            'zstd',
        ];

        $workflows = [];

        $output->writeln('Generating dockerfiles...');
        $loader = new \Twig\Loader\FilesystemLoader($this->projectDir.'/template');
        $twig = new \Twig\Environment($loader);
        foreach (['8.2', '8.1', '8.0', '7.4'] as $version) {
            foreach (['fpm', 'fpm-alpine', 'cli', 'cli-alpine'] as $tag) {
                $platformsTemp = $platforms;
                if (in_array("{$version}-{$tag}", $excludeArmv7Tags)) {
                    $platformsTemp = array_filter($platformsTemp, function ($platform): bool {
                        return strpos($platform, 'arm/v7') === false;
                    });
                }
                $workflows[] = [
                    'file' => str_replace('.', '', "publish-{$version}-{$tag}"),
                    'name' => "Publish {$version}-{$tag}",
                    'tag' => "{$version}-{$tag}",
                    'dockerfile' => "dockerfile/{$version}/{$tag}/Dockerfile",
                    'platforms' => implode(',', $platformsTemp),
                ];

                $dir = "{$this->projectDir}/dockerfile/{$version}/{$tag}";
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }

                $os = strpos($version, 'alpine') !== false ? 'alpine' : 'debian';

                $content = $twig->render("Dockerfile.{$os}.twig", [
                    'tag' => "{$version}-{$tag}",
                    'extensions' => implode(' ', $extensions),
                ]);
                $path = $dir.'/Dockerfile';
                file_put_contents($path, $content);

                $output->writeln('output: '.$path);
            }
        }

        $output->writeln(['', 'Generating Github Workflow files...']);
        foreach ($workflows as $workflow) {
            $content = $twig->render('publish-docker-hub.twig', $workflow);
            $path = "{$this->projectDir}/.github/workflows/{$workflow['file']}.yml";
            file_put_contents($path, $content);
            $output->writeln('output: '.$path);
        }

        $output->writeln(['', 'Done.']);

        return Command::SUCCESS;
    }
}

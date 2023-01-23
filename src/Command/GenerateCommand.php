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

        $extensions = ['amqp', 'apcu', 'bcmath', 'bz2', 'event', 'exif', 'gd', 'gnupg', 'imagick',
            'memcached', 'mongodb', 'mysqli', 'opcache', 'pcntl', 'pdo_mysql', 'pdo_pgsql',
            'pgsql', 'protobuf', 'redis', 'ssh2', 'swoole', 'xdebug', 'zip', 'zstd'];

        $jobs = [];

        $output->writeln('Generating dockerfiles...');
        $loader = new \Twig\Loader\FilesystemLoader($this->projectDir.'/template');
        $twig = new \Twig\Environment($loader);
        foreach (['8.2', '8.1', '8.0'] as $version) {
            foreach (['fpm', 'fpm-alpine', 'cli', 'cli-alpine'] as $tag) {
                $jobs[] = [
                    'name' => str_replace(['.', '-'], ['', '_'], "build_{$version}_{$tag}"),
                    'tag' => "{$version}-{$tag}",
                    'file' => "dockerfile/{$version}/{$tag}/Dockerfile",
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

        $output->writeln(['', 'Generating Github workflows...']);
        $content = $twig->render('publish-docker-hub.twig', ['jobs' => $jobs]);
        $path = "{$this->projectDir}/.github/workflows/publish-docker-hub.yml";
        file_put_contents($path, $content);
        $output->writeln('output: '.$path);

        $output->writeln(['', 'Done.']);

        return Command::SUCCESS;
    }
}

<?php

namespace StatamicVaporCompatibility\Commands;

use Illuminate\Console\Command;
use function basename;
use function file_get_contents;
use function file_put_contents;
use function stristr;

class CheckDockerfileContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statamic-vapor:check-dockerfile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Dockerfile for necessary lines.';

    /**
     * Necessary content for Dockerfile.
     *
     * @var string
     */
    protected string $necessaryContent = 'RUN \
    rm -rf /var/task/content/ \
    && rm -rf /var/task/users/ \
    && rm -rf /var/task/resources/blueprints/ \
    && rm -rf /var/task/resources/fieldsets/ \
    && rm -rf /var/task/resources/forms/ \
    && rm -rf /var/task/resources/users/ \
    && rm -rf /var/task/public/vendor/statamic/cp/svg/ \
    && rm -rf /var/task/public/vendor/statamic/cp/img/ \
    && ln -s /tmp/statamic-files/content /var/task/content \
    && ln -s /tmp/statamic-files/users /var/task/users \
    && ln -s /tmp/statamic-files/resources/blueprints /var/task/resources/blueprints \
    && ln -s /tmp/statamic-files/resources/fieldsets /var/task/resources/fieldsets \
    && ln -s /tmp/statamic-files/resources/forms /var/task/resources/forms \
    && ln -s /tmp/statamic-files/resources/users /var/task/resources/users \
    && ln -s /var/task/vendor/statamic/cms/resources/svg /var/task/public/vendor/statamic/cp/svg \
    && ln -s /var/task/vendor/statamic/cms/resources/img /var/task/public/vendor/statamic/cp/img';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->warn('Checking all .Dockerfile files for necessary content.');
        $dockerfiles = glob(base_path('') . '/*.Dockerfile');

        foreach($dockerfiles as $file) {
            $this->newLine(1);
            $this->info('  Processing file "' . basename($file) . '":');

            $content = file_get_contents($file);

            $newContent = $this->checkIfExpectedContentExists($content);

            if($content !== $newContent) {
                $this->warn('  Extending file with necessary content.');
                file_put_contents($file, $newContent);
                $this->info('  Saved file.');

                continue;
            }

            $this->info('  File already has necessary modifications.');
        }

        $this->newLine(1);
        $this->warn('All done!');

        return 0;
    }

    protected function checkIfExpectedContentExists($content)
    {
        if(stristr($content, $this->necessaryContent) === false) {
            return $content . PHP_EOL . PHP_EOL . $this->necessaryContent;
        }

        return $content;
    }
}

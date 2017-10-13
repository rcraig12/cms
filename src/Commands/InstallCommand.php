<?php
namespace RCS\CMS\Commands;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
/*use Intervention\Image\ImageServiceProviderLaravel5;*/
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;
/*use RCS\CMS\Traits\Seedable;*/
<<<<<<< HEAD
use RCS\CMS\CMSServiceProvider;
=======
use RCS\CMS\LaravelCMSServiceProvider;
>>>>>>> 3862811a4a79bdd036b8bd60b61d3523efcafbf2
class InstallCommand extends Command
{
    use Seedable;
    protected $seedersPath = __DIR__.'/../../publishable/database/seeds/';
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'cms:install';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the CMS package';
    protected function getOptions()
    {
        return [
            ['with-dummy', null, InputOption::VALUE_NONE, 'Install with dummy data', null],
        ];
    }
    /**
     * Get the composer command for the environment.
     *
     * @return string
     */
    protected function findComposer()
    {
        if (file_exists(getcwd().'/composer.phar')) {
            return '"'.PHP_BINARY.'" '.getcwd().'/composer.phar';
        }
        return 'composer';
    }
    public function fire(Filesystem $filesystem)
    {
        return $this->handle($filesystem);
    }
    /**
     * Execute the console command.
     *
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     *
     * @return void
     */
    public function handle(Filesystem $filesystem)
    {
        /*$this->info('Setting up the hooks');
        $this->call('hook:setup');*/
        $this->info('Publishing the CMS assets, database, language, and config files');
<<<<<<< HEAD
        $this->call('vendor:publish', ['--provider' => CMSServiceProvider::class]);
=======
        $this->call('vendor:publish', ['--provider' => LaravelCMSServiceProvider::class]);
>>>>>>> 3862811a4a79bdd036b8bd60b61d3523efcafbf2
        /*$this->call('vendor:publish', ['--provider' => ImageServiceProviderLaravel5::class]);*/
        $this->info('Migrating the database tables into your application');
        $this->call('migrate');
        $this->info('Attempting to set CMS User model as parent to App\User');
        if (file_exists(app_path('User.php'))) {
            $str = file_get_contents(app_path('User.php'));
            if ($str !== false) {
                $str = str_replace('extends Authenticatable', "extends \RCS\CMS\Models\User", $str);
                file_put_contents(app_path('User.php'), $str);
            }
        } else {
            $this->warn('Unable to locate "app/User.php".  Did you move this file?');
            $this->warn('You will need to update this manually.  Change "extends Authenticatable" to "extends \RCS\CMS\Models\User" in your User model');
        }
        $this->info('Dumping the autoloaded files and reloading all new files');
        $composer = $this->findComposer();
        $process = new Process($composer.' dump-autoload');
        $process->setWorkingDirectory(base_path())->run();
<<<<<<< HEAD
        $this->info('Adding CMS routes to routes/web.php');
=======
        $this->info('Adding Voyager routes to routes/web.php');
>>>>>>> 3862811a4a79bdd036b8bd60b61d3523efcafbf2
        $routes_contents = $filesystem->get(base_path('routes/web.php'));
        if (false === strpos($routes_contents, 'CMS::routes()')) {
            $filesystem->append(
                base_path('routes/web.php'),
                "\n\nRoute::group(['prefix' => 'admin'], function () {\n    CMS::routes();\n});\n"
            );
        }
        \Route::group(['prefix' => 'admin'], function () {
            \LaravelCMS::routes();
        });
        /*$this->info('Seeding data into the database');
        $this->seed('LaravelCMSDatabaseSeeder');*/
        if ($this->option('with-dummy')) {
<<<<<<< HEAD
            $this->seed('CMSDummyDatabaseSeeder');
=======
            $this->seed('LaravelCMSDummyDatabaseSeeder');
>>>>>>> 3862811a4a79bdd036b8bd60b61d3523efcafbf2
        }
        $this->info('Adding the storage symlink to your public folder');
        $this->call('storage:link');
        $this->info('Successfully installed CMS! Enjoy');
    }
}
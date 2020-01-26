use PHPFile;
use LaravelFile;

// find files with the query builder
PHPFile::in('database/migrations')
	->where('classExtends', 'Migration')
	->andWhere('className', 'like', 'Create')
	->get()
	->each(function($file) {
		// Do something
		$file->addUses(['Database\CustomMigration'])
			->classExtends('Database\CustomMigration')
			->save();
	});

// add relationship methods
LaravelFile::load('app/User.php')
	->addHasManyMethods(['App\Car'])
	->addHasOneMethods(['App\Life'])
	->addBelongsToMethods(['App\Wife'])
	->classMethodNames()

// move User.php to a Models directory
PHPFile::load('app/User.php')
	->namespace('App\Models')
	->move('app/Models/User.php')

// install a package trait
PHPFile::load('app/User.php')
	->addUseStatements('Package\Tool')
	->addTraitUseStatement('Tool')
	->save()

// add a route
LaravelFile::load('routes/web.php')
	->addRoute('dummy', 'Controller@method')
	->save()
	
// debug will write result relative to storage/.debug
LaravelFile::load('app/User.php')
	->setClassName('Mistake')
	->debug()

// add items to protected properties
LaravelFile::load('app/User.php')
	->addFillable('message')
	->addCasts(['is_admin' => 'boolean'])
	->addHidden('secret')	

// create new files from templates
LaravelFile::model('Beer')
	->save()
LaravelFile::controller('BeerController')
	->save()

// many in one go
LaravelFile::create('Beer', ['model', 'controller', 'migration'])
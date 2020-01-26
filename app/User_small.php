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
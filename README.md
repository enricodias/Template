# Template

A simple template class, originally created in 2006.

## Basic Usage

The class works by loading files in memory and replacing variables delimited by ```{$``` and ```}```.

```
$Template = new Template('/path/to/file.tpl'); // Load file.tpl
$Template->replace('var', 'Random Value');     // replace "{$var}" with "Random Value"

echo $Template;
```

## Reloading files

The ```reload``` function reloads a file from memory. It prevents reading the same file from the filesystem in loops.

```
$Template = new Template('head.tpl');

for ($i = 0; $i < 10, ++$i) {
  $Template->reload('row.tpl');
  $Template->replace('RowNumber', $i);
}

$Template->reload('footer.tpl');

echo $Template;
```

## Documentation

A more detailed documentation specifying all features is available in the <a href="https://github.com/enricodias/Template/wiki" title="Wiki">Wiki</a>.

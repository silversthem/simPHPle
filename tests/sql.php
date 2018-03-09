<?php

include '/var/www/htdocs/simPHPle/simPHPle/autoloader.php';
include '/var/www/htdocs/simPHPle/simPHPle/aliases.php';

/* First test, schema and table only */

class Blog0 extends Schema {
  public $name = 'simPHPle_tests';
  public $tables = [
    'authors' => [
      'key' => [
        'name' => 'varchar(128)'
      ],
      'fields' => [
        'website' => 'varchar(128)',
        'email' => 'varchar(128)'
      ]
    ],
    'articles' => [
      'fields' => [
        'message' => 'varchar(256)'
      ],
      'keys' => [
        'authors' => 'author_id'
      ]
    ],
    'comments'  => [
      'fields' => [
        'comment' => 'varchar(256)'
      ],
      'keys' => [
        'articles' => 'article_id',
        'authors' => 'author_id'
      ]
    ]
  ];
}

// Common to both tests
$database = new Database('mysql','localhost','root','password');

/* Starting test 1 */

function test_create($blog) {
  return $blog->create(); // Creating schema & tables
}

function test_insert($authors,$articles,$comments) {
  $article_author = $authors->insert(['name' => 'John'])->get(); // Adding an author
  $comment_author = $authors->insert(['name' => 'Jane'])->get(); // Adding an other author
  $article = $article_author->articles->insert(['message' => 'Hello world !'])->get(); // Creating a post from the first author
  return $comment_author->comments->insert(['comment' => 'Hi !'],$article)->success(); // Creating a comment from the second author
}

function test_select($authors,$articles,$comments) {

}

function test_update($authors,$articles,$comments) {

}

function test_search($authors,$articles,$comments) {

}

function test_delete($authors,$articles,$comments) {

}

function test_drop($blog) {
  return $blog->drop(); // Drops schema
}

$blog = new Blog0($database);
// Table access
$authors = $blog->authors;
$articles = $blog->articles;
$comments = $blog->comments;

if(!test_create($blog)) {echo "Create test failed\n";}
if(!test_insert($authors,$articles,$comments)) {echo "Insert test failed\n";}
if(!test_select($authors,$articles,$comments)) {echo "Select test failed\n";}
if(!test_update($authors,$articles,$comments)) {echo "Update test failed\n";}
if(!test_search($authors,$articles,$comments)) {echo "Search test failed\n";}
if(!test_delete($authors,$articles,$comments)) {echo "Delete test failed\n";}
if(!test_drop($blog)) {echo "Drop test failed\n";}

/* Starting test 2 */



// class Schema0 extends Schema {
//   public $name   = 'simPHPle_tests';
//   public $models = ['messages' => 'Message','comments' => 'Comment','authors' => 'Author'];
// }
//
// class Author extends Model {
//   public $key = [
//     'name' => 'varchar(128)'
//   ];
//   public $fields = [
//     'website' => 'varchar(128)',
//     'email'   => 'varchar(128)'
//   ];
// }
//
// class Message extends models\Entry {
//   public $fields = [
//     'message' => 'varchar(128)'
//   ];
//   public $keys = [
//     'Author' => 'author_id'
//   ];
// }
//
// class Comment extends models\Entry {
//   public $fields = [
//     'comment' => 'varchar(128)',
//   ];
//   public $keys = [
//     'Message' => 'message_id',
//     'Author'  => 'author_id'
//   ];
// }
//
// $db = new Database('mysql','localhost','root','password');
// $schema = new Schema0($db);

/* Model & Schema Query Generation */

// Creation

// $schema->create();
// $schema->authors->create();
// $schema->messages->create();
// $schema->comments->create();

// Insertion

// echo $schema->authors->insert(['name' => 'John','website' => 'http://johndoe.com','email' => 'john@doe.com'])."\n";
// echo $schema->authors->insert(['name' => 'Jane','website' => 'http://janedoe.com','email' => 'jane@doe.com'])."\n";
// echo $schema->authors->key(['name' => 'John'])->messages->insert(['message' => 'Hello there'])."\n";
// echo $schema->authors->key(['name' => 'John'])->messages->key(['id' => 7])->comments->insert(['comment' => 'Hi'])."\n";

// Selection

// $messages = $schema->messages;
// $messages->select()->foreach(function($message) {
//   var_dump($message->data());
// });

// Update

// $messages->key(['id' => 7])->update(['message' => 'Bye !']);
// $comment = $messages->key(['id' => 7])->comments->key(['id' => 8]);
// $comment['comment'] = 'Bye...';
// $comment->update();

// Search

// Delete

// Drop

//$schema->drop();

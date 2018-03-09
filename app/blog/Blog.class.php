<?php
/*

*/

class Blog extends Component {
  /* Properties */
  static $ARTICLES_PER_PAGE = 6;
  /* Database */
  public $schema = 'simPHPle_tests';
  public $tables = [
    'articles' => [
      'fields' => [
        'title'   => 'varchar(256)',
        'content' => 'varchar(3000)',
        'date'    => 'datetime'
      ]
    ],
    'comments' => [
      'fields' => [
        'author' => 'varchar(128)',
        'email' => 'varchar(128)',
        'website' => 'varchar(128)',
        'content' => 'varchar(800)'
      ],
      'keys' => [
        'articles' => 'article_id'
      ]
    ]
  ];

  public function routes($router) {
    $router->url('/','read_articles',[0,self::$ARTICLES_PER_PAGE]);
    $router->url('article/{id}','read_article');
    $router->url('page/{n}',function($request) {

    });
    $router->post('article/{id}',function($request) {
      $this->add_comment($request->url('id'),$request->data());
    },Post::required('author','content'));
  }
  public function read_articles($from,$to) {
    return $this->articles->select()->range($from,$to)->desc('date');
  }
  public function read_article($id) {
    return $this->articles->select(['id' => $id]);
  }
  public function add_comment($article_id,$data) {
    return $this->read_article($article_id)->comments->insert($data);
  }
}

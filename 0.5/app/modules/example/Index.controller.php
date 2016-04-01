<?php
/* Example module
  Normally the model and the controller won't be in the same file, but this is for testing
*/

class Index extends Controller
{
  public function getManager()
  {
    return new managers\Article();
  }
  public function showArticles($articles)
  {
    foreach($articles as $article)
    {
      $this->showArticle($article).'<br/>';
    }
  }
  public function showArticle($article)
  {
    echo '<b>'.$article.'</b>';
  }
  public function writeArticle()
  {
    echo '<form><input type="text" placeholder="Name" name="name"/><input type="submit"/></form>';
  }
  public function getFormEvent()
  {
    return Form::create('GET')->addField('name');
  }
}
?>

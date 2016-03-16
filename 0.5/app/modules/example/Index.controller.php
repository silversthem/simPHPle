<?php
/* Example module
  Normally the model and the controller won't be in the same file, but this is for testing
*/

class ArticleManager
{
  const ARTICLES_PER_PAGE = 10;

  public function newArticle($name)
  {
    echo 'Created article : '.$name;
    return 1;
  }
  public function getArticle($id)
  {
    if($id < 100)
    {
      return 'Article '.$id;
    }
    else
    {
      throw new Exception("Can't get article $id", 1);
    }
  }
  public function getPage($page)
  {
    if($page < 10)
    {
      $articles = array();
      for($i = 0;$i < ARTICLES_PER_PAGE;$i++)
      {
        try
        {
          $articles[] = $this->getArticle($page*10 + $i);
        }
        catch(Exception $e)
        {
          break;
        }
      }
      return $articles;
    }
    else
    {
      throw new Exception("Can't get page $page", 1);
    }
  }
}

class Index
{
  public function getModel()
  {
    return new ArticleManager();
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

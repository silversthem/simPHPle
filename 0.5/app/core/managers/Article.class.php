<?php
/*
  Test model
*/

namespace managers;

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
?>

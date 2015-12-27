<template>
<html tid="index">
  <head charset="utf-8" title="{{TITLE}}" css="{{STYLE}}"/>
  <body>
    <header id="mainheader">SIM<span class="plogo">P</span><span class="logo">HP</span>LE</header>
    <nav id="mainnav">
      <ul>
        <li class="index.loaded ? active"><a href="makeurl(index.html)">Index</a></li>
        <li class="articles.loaded ? active"><a href="makeurl(articles/)">Articles</a></li>
        <li class="forum.loaded ? active"><a href="makeurl(forum/)">Forum</a></li>
        <li class="wiki.loaded ? active"><a href="makeurl(wiki/)">Wiki</a></li>
        <li class="simphple.loaded ? active"><a href="makeurl(simphple/)">Simphple</a></li>
      </ul>
    </nav>
    <aside>
      {{ASIDE}}
    </aside>
    <div id="main">
      {{DISPLAY}}
    </div>
    <footer>stuff</footer>
  </body>
</html>
<html tid="aside">
  <aside>
    <ul>
    </ul>
  </aside>
</html>
</template>

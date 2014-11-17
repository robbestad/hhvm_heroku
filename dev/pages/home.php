<header class="topbar">
    <nav class="width">
        <a href="http://hhvm.com/"><h1>HHVM</h1></a>

        <div class="menu-top-menu-container">
            <ul id="menu-top-menu" class="menu">
                <li id="menu-item-119" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-119"><a
                        href="http://www.robbestad.com">Blog</a></li>
                <li id="menu-item-95" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-95"><a
                        href="https://github.com/svenanders/hhvm_heroku">Github</a></li>
            </ul>
        </div>
    </nav>
</header>


<section class="content">
    <div class="width">
        <article>
            <article class="page">
                <h2><a href="https://fierce-lake-5417.herokuapp.com/" rel="bookmark" 
                title="HHVM on Heroku">HHVM on Heroku</a>
                </h2>
                <p>
                This is a demo repo showing how you can get
                up and running on HHVM with Heroku. <a href="http://www.robbestad.com/2014/11/adventures-in-hiphop-vm.html"
                >Read this blog article</a> detailing how you get it running.
                </p>
            
                <?php
                if (defined('HHVM_VERSION')) {
                        echo "<p>This page is running on HHVM ", HHVM_VERSION, " </p>\n";
                    }
                ?>
                <div class="clear_column"></div>

            </article>

            <hr>
            <br>
        </article>

        

    </div>
</section>


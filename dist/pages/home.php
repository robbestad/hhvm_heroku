<header class="topbar">
    <nav class="width">
        <a href="#"><h3>HipHopVM on Heroku</h3></a>

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

                <p>
                To get going, do the following:
                </p>
                <p>
                <pre>
git clone https://github.com/svenanders/hhvm_heroku
cd hhvm_heroku
heroku create
heroku config:set WWWROOT=/dist
heroku config:set BUILDPACK_URL=https://github.com/heroku/heroku-buildpack-php
git push heroku master
                </pre>
                </p>

                <p>
                    So, what's going on above? The first two lines simply
                    downloads the code that powers this site. Next up assumes
                    you have installed Heroku toolbelt. If not, head over 
                    to <a href="http://www.heroku.com">Heroku.com</a>, get 
                    yourself an account and install the toolbelt.

                </p>

                <p>
                Next, you create a repo and set two config variables. The first
                set the docroot to <em>/dist</em> and the next lets Heroku know
                you want a PHP enabled system. Finally, you push the code
                to Heroku.
                </p>

                <p>If you're wondering about <em>/dist</em>, just take a look
                 at the file structure. All changes are done in the 
                <em>/dev</em> folder, and the <em>/dist</em> folder gets
                generated by executing <em>gulp</em> (Note: you need to 
                install the dependencies first by typing <em>npm install</em>
                if you want to do this). 
                </p>

<p>The advantage of this setup is that you always have a setup that is
ready to deploy.
</p>
            </article>

            <hr>
            <br>
        </article>

        

    </div>
</section>


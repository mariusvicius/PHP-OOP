<h1>Autoparko registratūros instaliacija</h1>
<article class="content">
    <p style="text-align: center;">Norint pradėti pirmiausiai reikia sukurti duombazę ir viskas.</p>
    <?php
        if(!empty($_POST['host']) && !empty($_POST['user']) && !empty($_POST['dbname'])){

            echo '<p style="text-align: center;">Luktelkit...</p>';

            $installer = new Installer();

            $installer->put( 'host', htmlspecialchars($_POST['host']) );
            $installer->put( 'user', htmlspecialchars($_POST['user']) );
            $installer->put( 'psw', htmlspecialchars($_POST['psw']) );
            $installer->put( 'dbName', htmlspecialchars($_POST['dbname']) );

            $installer->install( 'config.php' , 'includes/classes/Database/');

            header("Refresh:0");
        }else{
    ?>
    <div class="install-form">
        <form method="post">
            <p>
                <label>Serveris</label>
                <input type="text" class="input-text" name="host" value="" placeholder="localhost"/>
            </p>
            <p>
                <label>Vartotojas</label>
                <input type="text" class="input-text" name="user" value="" placeholder="root"/>
            </p>
            <p>
                <label>Slaptažodis</label>
                <input type="text" class="input-text" name="psw" value=""/>
            </p>
            <p>
                <label>Duomenų bazė</label>
                <input type="text" class="input-text" name="dbname" value="" placeholder="transport_base"/>
            </p>
            <p>
                <input type="submit" value="Instaliuoti" />
            </p>
        </form>
    </div>
    <?php } ?>
</article>
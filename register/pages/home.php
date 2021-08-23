<h1>Autoparko registratūra</h1>
<article class="content">
    <nav class="navigation">
        <div class="filter-area">
            <div class="form-wrapper">
                <form id="search">
                    <span class="input-wrap">
                        <input id="search-text-input" class="input-text" type="text" name="search" value="" placeholder="Įveskite žodį" />
                        <span id="clear">x</span>
                    </span>
                    <select name="search-by">
                        <option value="plates">Pagal valstybinį numerį</option>
                        <option value="manufacturer_name">Pagal gamintoją</option>
                        <option value="model_name">Pagal modelį</option>
                    </select>
                    <input type="hidden" name="action" value="search"/>
                    <input type="submit" value="Ieškoti"/>
                </form>
            </div>
        </div>
        <a href="#" id="add-register" class="btn">Pridėti transportą</a>
    </nav>
    <section id="register-list">
        <?php echo $registerView->showAllRegisters(); ?>
    </section>
</article>
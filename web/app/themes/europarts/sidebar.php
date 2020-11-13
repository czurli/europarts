<div class="sidebar">
    <div id="sidebar-bar" class="bg-primary py-1 px-3 text-white d-flex d-block d-lg-none">
        <div class="text d-flex w-100 align-items-center">Filtra</div>
        <div class="button d-flex justify-content-end w-100 ">
            <button id="sidebar-button">Apri</button>
        </div>
    </div>
    <div id="sidebar-content"">
        <div class="scroller">
            <div class="filters-menu mx-1 mt-2 mb-2 mb-lg-4 py-1 py-lg-3 px-3 px-lg-4">
                <?php dynamic_sidebar('shop-filtri'); ?>
            </div>
            <div class="categories-menu mx-1 mt-2 mb-2 mb-lg-4 py-1 py-lg-3 px-3 px-lg-4">
                <?php dynamic_sidebar('shop-categorie'); ?>
            </div>
        </div>
    </div>
</div>

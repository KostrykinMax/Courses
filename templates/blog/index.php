<?php
// templates/blog/index.php
// Данные приходят из BlogController
$categories = $categories ?? ['all' => 'Все'];
$posts = $posts ?? [];
?>

<div class="container" style="padding: 40px 20px;">
    <h1 style="margin-bottom: 40px; text-align: center;">Блог об изучении языков</h1>
    
    <!-- Фильтры и поиск -->
    <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 40px; justify-content: space-between; align-items: center;">
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <select id="categoryFilter" class="form-control" style="width: 200px;">
                <?php foreach ($categories as $value => $name): ?>
                <option value="<?php echo $value; ?>"><?php echo $name; ?></option>
                <?php endforeach; ?>
            </select>
            
            <select id="sortFilter" class="form-control" style="width: 200px;">
                <option value="newest">Сначала новые</option>
                <option value="popular">Самые популярные</option>
            </select>
        </div>
        
        <div style="position: relative; width: 300px;">
            <input type="text" id="blogSearch" class="form-control" placeholder="Поиск по статьям...">
            <span style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: var(--gray-400);">🔍</span>
        </div>
    </div>
    
    <!-- Сетка блога -->
    <div id="blogGrid" class="blog-grid">
        <?php foreach ($posts as $post): ?>
        <div class="blog-card" 
             data-category="<?php echo htmlspecialchars($post['category']); ?>" 
             data-views="<?php echo (int)$post['views']; ?>" 
             data-comments="<?php echo (int)$post['comments']; ?>" 
             data-date="<?php echo strtotime($post['date']); ?>">
            <div class="blog-image">
                <img src="<?php echo BASE_URL . $post['image']; ?>" 
                     alt="<?php echo htmlspecialchars($post['title']); ?>" 
                     onerror="this.src='<?php echo asset('images/placeholder.svg'); ?>'">
                <span class="blog-category" style="position: absolute; top: 15px; left: 15px; background: var(--primary); color: white; padding: 5px 12px; border-radius: 20px; font-size: 0.8rem;">
                    <?php echo htmlspecialchars($post['category']); ?>
                </span>
            </div>
            <div class="blog-content">
                <div class="blog-meta" style="display: flex; gap: 15px; color: var(--gray-400); font-size: 0.9rem; margin-bottom: 10px;">
                    <span>📅 <?php echo date('d F Y', strtotime($post['date'])); ?></span>
                </div>
                <h3 class="blog-title"><?php echo htmlspecialchars($post['title']); ?></h3>
                <p class="blog-excerpt"><?php echo htmlspecialchars($post['excerpt']); ?></p>
                
                <div class="blog-author" style="display: flex; align-items: center; gap: 10px; margin: 15px 0;">

                    <span><?php echo htmlspecialchars($post['author']); ?></span>
                </div>
                
                <a href="<?php echo url('?page=blog-post&id=' . $post['id']); ?>" class="btn btn-outline btn-sm">Читать далее</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Пагинация -->
    <div style="display: flex; justify-content: center; gap: 10px; margin-top: 50px;">
        <button class="btn btn-secondary" id="prevPage" disabled>← Предыдущая</button>
        <span style="padding: 10px 20px;" id="pageInfo">Страница 1 из 1</span>
        <button class="btn btn-secondary" id="nextPage" disabled>Следующая →</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const blogGrid = document.getElementById('blogGrid');
    const blogCards = Array.from(document.querySelectorAll('.blog-card'));
    const categoryFilter = document.getElementById('categoryFilter');
    const sortFilter = document.getElementById('sortFilter');
    const searchInput = document.getElementById('blogSearch');
    const prevBtn = document.getElementById('prevPage');
    const nextBtn = document.getElementById('nextPage');
    const pageInfo = document.getElementById('pageInfo');
    
    let currentPage = 1;
    const itemsPerPage = 6;
    let filteredCards = blogCards;
    
    function filterAndSort() {
        const category = categoryFilter.value;
        const search = searchInput.value.toLowerCase().trim();
        
        filteredCards = blogCards.filter(card => {
            const matchesCategory = category === 'all' || card.dataset.category === category;
            const title = card.querySelector('.blog-title').textContent.toLowerCase();
            const excerpt = card.querySelector('.blog-excerpt').textContent.toLowerCase();
            const matchesSearch = search === '' || title.includes(search) || excerpt.includes(search);
            return matchesCategory && matchesSearch;
        });
        
        const sort = sortFilter.value;
        filteredCards.sort((a, b) => {
            if (sort === 'newest') {
                return parseInt(b.dataset.date) - parseInt(a.dataset.date);
            } else{
                return parseInt(b.dataset.views) - parseInt(a.dataset.views);
            }
            return 0;
        });
        
        updatePagination();
    }
    
    function updatePagination() {
        const totalPages = Math.ceil(filteredCards.length / itemsPerPage);
        
        blogCards.forEach(card => card.style.display = 'none');
        
        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        filteredCards.slice(start, end).forEach(card => card.style.display = 'block');
        
        pageInfo.textContent = `Страница ${currentPage} из ${totalPages || 1}`;
        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages || totalPages === 0;
    }
    
    categoryFilter.addEventListener('change', () => {
        currentPage = 1;
        filterAndSort();
    });
    
    sortFilter.addEventListener('change', () => {
        currentPage = 1;
        filterAndSort();
    });
    
    let searchTimer;
    searchInput.addEventListener('input', () => {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => {
            currentPage = 1;
            filterAndSort();
        }, 300);
    });
    
    prevBtn.addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            updatePagination();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    });
    
    nextBtn.addEventListener('click', () => {
        const totalPages = Math.ceil(filteredCards.length / itemsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            updatePagination();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    });
    
    filterAndSort();
});
</script>

<style>
.blog-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
}

.blog-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.blog-card .blog-image {
    position: relative;
    overflow: hidden;
}

.blog-card:hover .blog-image img {
    transform: scale(1.05);
}

.blog-card .blog-image img {
    transition: transform 0.3s ease;
}
</style>
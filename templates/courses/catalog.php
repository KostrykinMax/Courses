<?php
?>
<div class="container" style="padding: 40px 20px;">
    <h1 style="margin-bottom: 30px;">Все курсы</h1>
    
    <!-- Фильтры -->
    <div style="background: var(--gray-100); padding: 20px; border-radius: var(--border-radius); margin-bottom: 40px;">
        <div style="display: flex; gap: 20px; flex-wrap: wrap; align-items: flex-end;">
            <div style="flex: 2; min-width: 250px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Поиск по названию</label>
                <input type="text" id="searchInput" class="form-control" placeholder="Введите название курса..." value="">
            </div>
            
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Сортировка</label>
                <select id="sortSelect" class="form-control">
                    <option value="newest">Сначала новые</option>
                    <option value="price_asc">Цена (по возрастанию)</option>
                    <option value="price_desc">Цена (по убыванию)</option>
                </select>
            </div>
            
            <div style="display: none; gap: 10px;">
                <button id="applyFilters" class="btn btn-primary">Применить</button>
                <button id="resetFilters" class="btn btn-secondary">Сбросить</button>
            </div>
        </div>
        
        <div id="filterIndicator" style="display: none; margin-top: 15px; text-align: center;">
            <span style="color: var(--primary);">Загрузка...</span>
        </div>
    </div>
    
    <!-- Информация о количестве -->
    <div id="resultsInfo" style="margin-bottom: 20px; color: var(--gray-600);">
        Загрузка курсов...
    </div>
    
    <div id="coursesGrid" class="courses-grid">
        <div style="text-align: center; padding: 40px; grid-column: 1 / -1;">
            <span style="color: var(--primary);">Загрузка...</span>
        </div>
    </div>
    
    <div id="pagination" style="display: flex; justify-content: center; gap: 10px; margin-top: 50px;">
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;
    let totalPages = 1;
    
    const searchInput = document.getElementById('searchInput');
    const sortSelect = document.getElementById('sortSelect');
    const coursesGrid = document.getElementById('coursesGrid');
    const resultsInfo = document.getElementById('resultsInfo');
    const pagination = document.getElementById('pagination');
    const filterIndicator = document.getElementById('filterIndicator');
    
    let searchTimer = null;
    
    function loadCourses() {
        filterIndicator.style.display = 'block';
        coursesGrid.innerHTML = '<div style="text-align: center; padding: 40px; grid-column: 1 / -1;"><span style="color: var(--primary);">Загрузка...</span></div>';
        
        const search = searchInput.value.trim();
        const sort = sortSelect.value;
        
        fetch('<?php echo url('?page=course-filter'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                'search': search,
                'sort': sort,
                'page': currentPage
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                coursesGrid.innerHTML = data.html;
                
                resultsInfo.innerHTML = `Найдено курсов: <strong>${data.total}</strong> | Страница <strong>${data.page}</strong> из <strong>${data.totalPages}</strong>`;
                
                updatePagination(data);
                
                currentPage = data.page;
                totalPages = data.totalPages;
            }
            
            filterIndicator.style.display = 'none';
        })
        .catch(error => {
            console.error('Ошибка:', error);
            coursesGrid.innerHTML = '<div style="text-align: center; padding: 40px; grid-column: 1 / -1; color: var(--danger);">Ошибка загрузки данных</div>';
            filterIndicator.style.display = 'none';
        });
    }
    
    function updatePagination(data) {
        if (data.totalPages <= 1) {
            pagination.innerHTML = '';
            return;
        }
        
        let html = '';
        
        if (data.hasPrev) {
            html += `<button class="btn btn-secondary page-btn" data-page="${data.page - 1}" style="padding: 10px 20px;">← Предыдущая</button>`;
        }
        
        let startPage = Math.max(1, data.page - 2);
        let endPage = Math.min(data.totalPages, data.page + 2);
        
        if (startPage > 1) {
            html += `<button class="btn btn-secondary page-btn" data-page="1" style="padding: 10px 15px;">1</button>`;
            if (startPage > 2) {
                html += `<span style="padding: 10px 15px;">...</span>`;
            }
        }
        
        for (let i = startPage; i <= endPage; i++) {
            html += `<button class="btn ${data.page == i ? 'btn-primary' : 'btn-secondary'} page-btn" data-page="${i}" style="padding: 10px 15px;">${i}</button>`;
        }
        
        if (endPage < data.totalPages) {
            if (endPage < data.totalPages - 1) {
                html += `<span style="padding: 10px 15px;">...</span>`;
            }
            html += `<button class="btn btn-secondary page-btn" data-page="${data.totalPages}" style="padding: 10px 15px;">${data.totalPages}</button>`;
        }
        
        if (data.hasNext) {
            html += `<button class="btn btn-secondary page-btn" data-page="${data.page + 1}" style="padding: 10px 20px;">Следующая →</button>`;
        }
        
        pagination.innerHTML = html;
        
        document.querySelectorAll('.page-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                currentPage = parseInt(this.dataset.page);
                loadCourses();
                window.scrollTo({
                    top: document.querySelector('.filters').offsetTop - 100,
                    behavior: 'smooth'
                });
            });
        });
    }
    
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => {
            currentPage = 1; 
            loadCourses();
        }, 300);
    });
    
    sortSelect.addEventListener('change', function() {
        currentPage = 1;
        loadCourses();
    });
    
    document.getElementById('applyFilters').addEventListener('click', function() {
        currentPage = 1;
        loadCourses();
    });
    
    document.getElementById('resetFilters').addEventListener('click', function() {
        searchInput.value = '';
        sortSelect.value = 'newest';
        currentPage = 1;
        loadCourses();
    });
    
    loadCourses();
});
</script>

<style>
/* Анимация загрузки */
@keyframes pulse {
    0% { opacity: 0.6; }
    50% { opacity: 1; }
    100% { opacity: 0.6; }
}

.loading {
    animation: pulse 1.5s infinite;
}

.page-btn {
    cursor: pointer;
    transition: all 0.3s ease;
}

.page-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}
</style>
<?php
$teachers = [
    [
        'id' => 1,
        'name' => 'Анна Петрова',
        'photo' => asset('images/teachers/teacher-1.jpg'),
        'languages' => ['Английский', 'Немецкий'],
        'specialization' => 'Бизнес-английский, подготовка к IELTS',
        'experience' => 8,
        'education' => 'МГУ им. Ломоносова, Кембриджский сертификат CELTA',
        'about' => 'Специализируюсь на деловом английском и подготовке к международным экзаменам. Помогла более 500 студентам успешно сдать IELTS.',
        'rating' => 4.9,
        'students' => 543,
        'lessons' => 2341,
        'price' => 2500,
        'video' => 'https://www.youtube.com/embed/example1',
        'lives_in' => 'Лондон'
    ],
    [
        'id' => 2,
        'name' => 'Markus Weber',
        'photo' => asset('images/teachers/teacher-2.jpg'),
        'languages' => ['Немецкий', 'Английский'],
        'specialization' => 'Немецкий для бизнеса, разговорный немецкий',
        'experience' => 12,
        'education' => 'Берлинский университет им. Гумбольдта',
        'about' => 'Носитель языка из Берлина. Обучаю деловому немецкому и готовлю к экзаменам TestDaF, Goethe-Zertifikat.',
        'rating' => 5.0,
        'students' => 678,
        'lessons' => 3124,
        'price' => 3000,
        'video' => 'https://www.youtube.com/embed/example2',
        'lives_in' => 'Берлин'
    ],
    [
        'id' => 3,
        'name' => 'Sophie Dubois',
        'photo' => asset('images/teachers/teacher-3.jpg'),
        'languages' => ['Французский', 'Английский'],
        'specialization' => 'Французский для начинающих, разговорный клуб',
        'experience' => 6,
        'education' => 'Сорбонна, Париж',
        'about' => 'Дипломированный преподаватель из Парижа. Помогу полюбить французский язык и заговорить без акцента.',
        'rating' => 4.8,
        'students' => 432,
        'lessons' => 1876,
        'price' => 2700,
        'video' => 'https://www.youtube.com/embed/example3',
        'lives_in' => 'Париж'
    ],
    [
        'id' => 4,
        'name' => 'Carlos Garcia',
        'photo' => asset('images/teachers/teacher-4.jpg'),
        'languages' => ['Испанский', 'Португальский'],
        'specialization' => 'Испанский для путешествий, латиноамериканский испанский',
        'experience' => 10,
        'education' => 'Университет Барселоны',
        'about' => 'Из Испании, жил в Мексике и Аргентине. Научу говорить на живом испанском и понимать разные акценты.',
        'rating' => 4.9,
        'students' => 765,
        'lessons' => 2987,
        'price' => 2600,
        'video' => 'https://www.youtube.com/embed/example4',
        'lives_in' => 'Барселона'
    ],
    [
        'id' => 5,
        'name' => 'Giuseppe Romano',
        'photo' => asset('images/teachers/teacher-5.jpg'),
        'languages' => ['Итальянский', 'Английский'],
        'specialization' => 'Итальянский с нуля, разговорный итальянский',
        'experience' => 7,
        'education' => 'Римский университет Ла Сапиенца',
        'about' => 'Коренной итальянец из Рима. Влюблю вас в итальянский язык и культуру.',
        'rating' => 4.7,
        'students' => 321,
        'lessons' => 1543,
        'price' => 2800,
        'video' => 'https://www.youtube.com/embed/example5',
        'lives_in' => 'Рим'
    ],
    [
        'id' => 6,
        'name' => 'John Smith',
        'photo' => asset('images/teachers/teacher-6.jpg'),
        'languages' => ['Английский', 'Испанский'],
        'specialization' => 'Английский для IT, технический английский',
        'experience' => 9,
        'education' => 'Кембриджский университет',
        'about' => 'Британский преподаватель, специализируюсь на английском для программистов и IT-специалистов.',
        'rating' => 5.0,
        'students' => 654,
        'lessons' => 2765,
        'price' => 2900,
        'video' => 'https://www.youtube.com/embed/example6',
        'lives_in' => 'Лондон'
    ]
];

$languages = ['Английский', 'Немецкий', 'Французский', 'Испанский', 'Итальянский'];
$specializations = ['Бизнес', 'Разговорный', 'Для путешествий', 'Для IT', 'Экзамены', 'Для детей'];
?>

<div class="container" style="padding: 40px 20px;">
    <h1 style="margin-bottom: 40px; text-align: center;">Наши преподаватели</h1>
    
    <!-- Сетка преподавателей -->
    <div id="teachersGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 30px;">
        <?php foreach ($teachers as $teacher): ?>
        <div class="teacher-card" 
             data-languages='<?php echo json_encode($teacher['languages']); ?>'
             data-specialization="<?php echo htmlspecialchars($teacher['specialization']); ?>"
             data-price="<?php echo $teacher['price']; ?>"
             data-experience="<?php echo $teacher['experience']; ?>">
            <div style="position: relative;">
            </div>
            
            <div class="teacher-content">
                <h3 class="teacher-name"><?php echo $teacher['name']; ?></h3>
                
                <div style="display: flex; gap: 5px; flex-wrap: wrap; margin-bottom: 10px; justify-content: center;">
                    <?php foreach ($teacher['languages'] as $lang): ?>
                    <span style="background: var(--primary); color: white; padding: 3px 10px; border-radius: 20px; font-size: 0.8rem;"><?php echo $lang; ?></span>
                    <?php endforeach; ?>
                </div>
                
                <div style="display: flex; justify-content: center; gap: 15px; margin-bottom: 15px;">
                    <span style="color: var(--gray-600);">⭐ <?php echo $teacher['rating']; ?></span>
                    <span style="color: var(--gray-600);">👥 <?php echo $teacher['students']; ?></span>
                    <span style="color: var(--gray-600);">📚 <?php echo $teacher['lessons']; ?></span>
                </div>
                
                <p style="color: var(--gray-600); margin-bottom: 15px;"><?php echo $teacher['about']; ?></p>
                
                <div style="margin-bottom: 15px;">
                    <span style="background: var(--gray-100); padding: 5px 10px; border-radius: 20px; font-size: 0.9rem; margin-left: 5px;">🏠 <?php echo $teacher['lives_in']; ?></span>
                </div>
                
                <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 15px;">
                    <div>
                        <span style="font-size: 1.5rem; font-weight: 700; color: var(--primary);"><?php echo $teacher['price']; ?> ₽</span>
                        <span style="color: var(--gray-600);">/урок</span>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Если преподаватели не найдены -->
    <div id="noTeachersFound" style="display: none; text-align: center; padding: 60px;">
        <p style="font-size: 1.2rem; color: var(--gray-600); margin-bottom: 20px;">Преподаватели по заданным критериям не найдены</p>
        <button class="btn btn-primary" onclick="resetTeacherFilters()">Сбросить фильтры</button>
    </div>
    
    <!-- Статистика -->
    <div style="margin-top: 60px; display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; text-align: center;">
        <div style="padding: 30px; background: var(--gray-100); border-radius: var(--border-radius);">
            <div style="font-size: 2.5rem; font-weight: 800; color: var(--primary);">300+</div>
            <div>преподавателей</div>
        </div>
        <div style="padding: 30px; background: var(--gray-100); border-radius: var(--border-radius);">
            <div style="font-size: 2.5rem; font-weight: 800; color: var(--primary);">15+</div>
            <div>стран</div>
        </div>
        <div style="padding: 30px; background: var(--gray-100); border-radius: var(--border-radius);">
            <div style="font-size: 2.5rem; font-weight: 800; color: var(--primary);">50k+</div>
            <div>проведенных уроков</div>
        </div>
        <div style="padding: 30px; background: var(--gray-100); border-radius: var(--border-radius);">
            <div style="font-size: 2.5rem; font-weight: 800; color: var(--primary);">4.9</div>
            <div>средний рейтинг</div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const teachers = document.querySelectorAll('.teacher-card');
    const languageFilter = document.getElementById('languageFilter');
    const specializationFilter = document.getElementById('specializationFilter');
    const priceFrom = document.getElementById('priceFrom');
    const priceTo = document.getElementById('priceTo');
    const experienceFilter = document.getElementById('experienceFilter');
    const experienceValue = document.getElementById('experienceValue');
    const applyBtn = document.getElementById('applyTeacherFilters');
    const resetBtn = document.getElementById('resetTeacherFilters');
    const noTeachersFound = document.getElementById('noTeachersFound');
    
    experienceFilter.addEventListener('input', function() {
        experienceValue.textContent = this.value + '+ лет';
    });
    
    function filterTeachers() {
        const lang = languageFilter.value;
        const spec = specializationFilter.value;
        const from = priceFrom.value ? parseInt(priceFrom.value) : 0;
        const to = priceTo.value ? parseInt(priceTo.value) : Infinity;
        const exp = parseInt(experienceFilter.value);
        
        let visibleCount = 0;
        
        teachers.forEach(teacher => {
            const teacherLangs = JSON.parse(teacher.dataset.languages);
            const teacherSpec = teacher.dataset.specialization.toLowerCase();
            const teacherPrice = parseInt(teacher.dataset.price);
            const teacherExp = parseInt(teacher.dataset.experience);
            
            const matchesLang = lang === 'all' || teacherLangs.includes(lang);
            const matchesSpec = spec === 'all' || teacherSpec.includes(spec.toLowerCase());
            const matchesPrice = teacherPrice >= from && teacherPrice <= to;
            const matchesExp = teacherExp >= exp;
            
            if (matchesLang && matchesSpec && matchesPrice && matchesExp) {
                teacher.style.display = 'block';
                visibleCount++;
            } else {
                teacher.style.display = 'none';
            }
        });
        
        noTeachersFound.style.display = visibleCount === 0 ? 'block' : 'none';
    }
    
    applyBtn.addEventListener('click', filterTeachers);
    
    window.resetTeacherFilters = function() {
        languageFilter.value = 'all';
        specializationFilter.value = 'all';
        priceFrom.value = '';
        priceTo.value = '';
        experienceFilter.value = '0';
        experienceValue.textContent = '0+ лет';
        filterTeachers();
    };
    
    resetBtn.addEventListener('click', resetTeacherFilters);
});
</script>

<style>
.teacher-card {
    background: white;
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    transition: all 0.3s ease;
    text-align: center;
}

.teacher-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.teacher-photo {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    margin: 30px auto 20px;
    overflow: hidden;
    border: 3px solid var(--primary);
}

.teacher-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.teacher-content {
    padding: 0 20px 30px;
}
</style>
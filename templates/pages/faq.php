<?php
    $faqCategories = [
        'Общие вопросы' => [
            [
                'question' => 'Как начать обучение?',
                'answer' => 'Для начала обучения необходимо зарегистрироваться на сайте, выбрать подходящий курс и оплатить его. После оплаты вам откроется доступ к материалам курса. Также вы можете записаться на бесплатный пробный урок, чтобы познакомиться с платформой и преподавателем.'
            ],
            [
                'question' => 'Сколько длится обучение?',
                'answer' => 'Длительность курсов varies от 1 до 6 месяцев в зависимости от выбранной программы. В описании каждого курса указана точная продолжительность. Вы также можете заниматься в своем темпе, доступ к материалам сохраняется на весь период обучения.'
            ],
            [
                'question' => 'Нужно ли покупать учебники?',
                'answer' => 'Нет, все необходимые материалы доступны в личном кабинете. Мы предоставляем электронные учебники, рабочие тетради, аудио- и видеоматериалы. Вам нужен только компьютер или планшет с доступом в интернет.'
            ],
            [
                'question' => 'Есть ли пробный период?',
                'answer' => 'Да, мы предлагаем бесплатный пробный урок длительностью 30 минут. Вы познакомитесь с преподавателем, узнаете свой уровень языка и получите рекомендации по обучению. Записаться можно на главной странице.'
            ]
        ],
        'Оплата' => [
            [
                'question' => 'Какие способы оплаты принимаете?',
                'answer' => 'Мы принимаем банковские карты Visa, MasterCard, МИР, а также оплату через Яндекс.Кассу, Tinkoff Pay, SberPay. Для юридических лиц возможна оплата по счету.'
            ],
            [
                'question' => 'Можно ли вернуть деньги?',
                'answer' => 'Да, мы предоставляем гарантию возврата средств в течение 14 дней с момента оплаты, если вы не начали обучение или прошли не более 2 уроков. Для возврата необходимо написать в службу поддержки.'
            ],
            [
                'question' => 'Есть ли рассрочка?',
                'answer' => 'Да, для некоторых курсов доступна рассрочка без переплат от наших партнеров. Подробности уточняйте у менеджеров или в чате поддержки.'
            ],
            [
                'question' => 'Предоставляете ли вы закрывающие документы?',
                'answer' => 'Да, для физических лиц мы предоставляем чек, для юридических – акт выполненных работ и счет-фактуру. Документы отправляем на электронную почту.'
            ]
        ],
        'Технические вопросы' => [
            [
                'question' => 'На каких устройствах можно заниматься?',
                'answer' => 'Платформа работает на компьютерах, ноутбуках, планшетах и смартфонах. Достаточно современного браузера с поддержкой HTML5. Рекомендуем использовать Chrome, Firefox, Safari или Edge последних версий.'
            ],
            [
                'question' => 'Что делать, если не грузится видео?',
                'answer' => 'Проверьте скорость интернета, попробуйте перезагрузить страницу или использовать другой браузер. Если проблема не решается, обратитесь в техподдержку.'
            ],
            [
                'question' => 'Как связаться с преподавателем?',
                'answer' => 'В личном кабинете есть чат с преподавателем. Также вы можете задать вопросы во время онлайн-уроков или через форму обратной связи.'
            ]
        ],
        'Уроки и преподаватели' => [
            [
                'question' => 'Кто преподает курсы?',
                'answer' => 'У нас работают сертифицированные преподаватели и носители языка из разных стран. Все преподаватели имеют высшее лингвистическое образование и опыт работы от 3 лет. Вы можете выбрать преподавателя самостоятельно.'
            ],
            [
                'question' => 'Как проходят уроки?',
                'answer' => 'Уроки проходят на нашей интерактивной платформе. Вы видите преподавателя, материалы на экране, можете общаться в чате и выполнять интерактивные задания. Все уроки записываются, их можно пересмотреть.'
            ],
            [
                'question' => 'Можно ли перенести урок?',
                'answer' => 'Да, вы можете перенести урок не позднее чем за 4 часа до начала. Это можно сделать в личном кабинете в разделе "Расписание".'
            ]
        ]
    ];
?>

<div class="container" style="padding: 40px 20px;">
    <h1 style="margin-bottom: 40px; text-align: center;">Часто задаваемые вопросы</h1>
    
    <div style="max-width: 600px; margin: 0 auto 50px;">
        <div style="position: relative;">
            <input type="text" id="faqSearch" class="form-control" placeholder="Поиск по вопросам..." style="padding: 15px 20px; font-size: 1.1rem;">
            <span style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: var(--gray-400);">🔍</span>
        </div>
    </div>
    
    <div style="display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; margin-bottom: 40px;">
        <button class="btn btn-secondary faq-category-btn active" data-category="all">Все вопросы</button>
        <?php foreach (array_keys($faqCategories) as $category): ?>
        <button class="btn btn-secondary faq-category-btn" data-category="<?php echo $category; ?>"><?php echo $category; ?></button>
        <?php endforeach; ?>
    </div>
    
    <div id="faqContainer">
        <?php foreach ($faqCategories as $category => $questions): ?>
        <div class="faq-category" data-category="<?php echo $category; ?>">
            <h2 style="margin: 40px 0 20px; color: var(--primary); font-size: 14pt;"><?php echo $category; ?></h2>
            
            <?php foreach ($questions as $item): ?>
            <button class="accordion"><?php echo $item['question']; ?></button>
            <div class="panel">
                <p><?php echo $item['answer']; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endforeach; ?>
    </div>
    
    <div id="noResults" style="display: none; text-align: center; padding: 60px;">
        <p style="font-size: 1.2rem; color: var(--gray-600);">По вашему запросу ничего не найдено</p>
        <button class="btn btn-primary" onclick="resetSearch()" style="margin-top: 20px;">Сбросить поиск</button>
    </div>
</div>

<style>
.accordion {
    background-color: var(--gray-100);
    color: var(--dark);
    cursor: pointer;
    padding: 18px;
    width: 100%;
    text-align: left;
    border: none;
    outline: none;
    transition: 0.4s;
    font-weight: 600;
    font-size: 1rem;
    border-radius: var(--border-radius-sm);
    margin-bottom: 5px;
    border: 1px solid var(--gray-200);
}

.active, .accordion:hover {
    background-color: var(--primary);
    color: white;
}

.panel {
    padding: 0 18px;
    background-color: white;
    display: none;
    overflow: hidden;
    margin-bottom: 15px;
    line-height: 1.6;
}

.faq-category-btn.active {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }
    
    const searchInput = document.getElementById('faqSearch');
    const faqCategories = document.querySelectorAll('.faq-category');
    const noResults = document.getElementById('noResults');
    const categoryBtns = document.querySelectorAll('.faq-category-btn');
    const accordions = document.querySelectorAll('.accordion');
    const panels = document.querySelectorAll('.panel');
    
    let currentCategory = 'all';
    
    function filterFAQ() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        let visibleCount = 0;
        
        faqCategories.forEach(cat => {
            const category = cat.dataset.category;
            const questions = cat.querySelectorAll('.accordion');
            let categoryVisible = false;
            
            questions.forEach(question => {
                const questionText = question.textContent.toLowerCase();
                const panel = question.nextElementSibling;
                const answerText = panel ? panel.textContent.toLowerCase() : '';
                
                const matchesSearch = searchTerm === '' || questionText.includes(searchTerm) || answerText.includes(searchTerm);
                const matchesCategory = currentCategory === 'all' || category === currentCategory;
                
                if (matchesSearch && matchesCategory) {
                    question.style.display = 'block';
                    panel.style.display = 'none';
                    question.classList.remove('active');
                    categoryVisible = true;
                    visibleCount++;
                } else {
                    question.style.display = 'none';
                    panel.style.display = 'none';
                }
            });
            
            cat.style.display = categoryVisible ? 'block' : 'none';
        });
        
        noResults.style.display = visibleCount === 0 ? 'block' : 'none';
    }
    
    let searchTimer;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(filterFAQ, 300);
    });
    
    categoryBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            categoryBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentCategory = this.dataset.category;
            filterFAQ();
        });
    });
    
    window.resetSearch = function() {
        searchInput.value = '';
        currentCategory = 'all';
        categoryBtns.forEach(btn => btn.classList.remove('active'));
        document.querySelector('.faq-category-btn[data-category="all"]').classList.add('active');
        filterFAQ();
    };
});
</script>
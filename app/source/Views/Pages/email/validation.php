<section class="email-validation">
    <form method="post" action="/email/validation" class="email-validation__form">
        <label for="email">Введите e-mail:</label>
        <input name="email" placeholder="Максимальная длина: 255 символов" id="email"><br>
        <button type="submit">Проверить</button>
    </form>
    <?php if ($this->pageParams['email']): ?>
        <div class="email-validation__result">
            <h2>Результаты проверки e-mail:</h2>
            <div class="email-validation__result-item result-item">
                <span class="result-item__name">E-mail:</span>
                <span class="result-item__value"><?= $this->pageParams['email'] ?></span>
            </div>
            <div class="email-validation__result-item result-item">
                <span class="result-item__name">Валидно:</span>
                <span class="result-item__value"><?= $this->pageParams['isAllValid'] ? 'ОК' : 'Ошибка'?></span>
            </div>

            <h3>Подробности:</h3>
            <div class="email-validation__result-item result-item">
                <span class="result-item__name">Regex:</span>
                <span class="result-item__value"><?= $this->pageParams['isRegexValid'] ? 'ОК' : 'Ошибка'?></span>
            </div>
            <div class="email-validation__result-item result-item">
                <span class="result-item__name">DNS:</span>
                <span class="result-item__value"><?= $this->pageParams['isDnsValid'] ? 'ОК' : 'Ошибка'?></span>
                <?php if ($this->pageParams['isDnsValid']): ?>
                    <div class="result-item__dns-mx-list">
                        <h4>Список найденных MX записей:</h4>
                    <?php foreach ($this->pageParams['dnxMxList'] as $priority => $dnsMx): ?>
                        <p>
                            <span class="result-item__dns-mx-priority"><?=$priority?></span> - <span class="result-item__dns-mx-item"><?=$dnsMx?></span>
                        </p>
                    <?php endforeach;?>
                    </div>
                <?php endif;?>
            </div>
        </div>
    <?php endif;?>
</section>
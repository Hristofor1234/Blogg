<main>
    <div class="inner_container">
        <label>
            <span>Темa *</span>
            <input name="name" type = "text">
        </label>
        <label>
            <span>Обложка</span>
            <input name="cover" type = "text">
        </label>
        <p>Текст *</p>
        <div id="summernote"></div>
        <label>
            <span>Раздел</span>
            <select name = "main_tag">
                <option value = "Разработка">Разработка</option>
                <option value = "Дизайн">Дизайн</option>
                <option value = "Администрирование">Администрирование</option>
            </select>
        </label>
        <label>
            <span>Теги (через запятую)</span>
            <input name="tags" type = "text">
        </label>
        <button id="add_post">Добавить</button>
    </div>
</main>
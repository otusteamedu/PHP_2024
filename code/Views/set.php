<form id="set_news">
    <div style="display: flex">
        <label for="name">Название</label>
        <input name="name" id="name">
    </div>
    <div style="display: flex">
        <label for="author">Автор</label>
        <input name="author" id="author">
    </div>
    <div style="display: flex">
        <label for="category">Категория</label>
        <input name="category" id="category">
    </div>
    <div style="display: flex">
        <label for="text">Текст</label>
        <input name="text" id="text">
    </div>
    <div style="display: flex">
        <button type="button" id="set">Создать</button>
    </div>
</form>
<script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        $('#set').on('click', function () {
            let data = $( "#set_news" ).serializeArray();
            let result = { };
            $.each(data, function() {
                result[this.name] = this.value;
            });

            fetch('/post/setNews', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                },
                body: JSON.stringify(result)
            })
                .then(response => response.json())
                .then(response => {
                    if (1 === response.ok) {
                        window.location.href = '/news/by/id?id=' + response.content.id;
                    } else {
                        console.log(response.error)
                    }
                })
                .catch(error => console.log(error))
                .finally(() => {
                    console.log('success')
                })
        })
    })
</script>
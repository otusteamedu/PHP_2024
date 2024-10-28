<form id="subscribe">
    <div style="display: flex">
        <input type="hidden" name="user_id" value="1">
        <label for="category">Категория</label>
        <input name="category" id="category">
    </div>
    <div style="display: flex">
        <button type="button" id="subscribe">Подписаться</button>
    </div>
</form>
<script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        $('#subscribe').on('click', function () {
            let data = $( "#subscribe" ).serializeArray();
            let result = { };
            $.each(data, function() {
                result[this.name] = this.value;
            });

            fetch('/post/subscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                },
                body: JSON.stringify(result)
            })
                .then(response => response.json())
                .then(response => {
                    if (1 === response.ok) {
                        alert('Успешно')
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
<?php

echo "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'];
echo "\nСессия: " . $_SESSION['key'];
?>
<div class="request">

</div>

<script>
    fetch('http://mysite.local/string', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify({
            // string: '(()()()()))((((()()()))(()()()(((()))))))'
            string: '(()()()())((((()()()))(()()()(((()))))))'
        })
    })
        .then(response => response.json())
        .then(response => {
            if (1 === response.ok) {
                console.log(response)
            } else {
                console.log(response.error)
            }
        })
        .catch(error => console.log(error))
        .finally(() => {
            console.log('success')
        })
    fetch('http://mysite.local/string', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify({
            string: '(()()()()))((((()()()))(()()()(((()))))))'
            // string: '(()()()())((((()()()))(()()()(((()))))))'
        })
    })
        .then(response => response.json())
        .then(response => {
            if (1 === response.ok) {
                console.log(response.content)
            } else {
                console.log(response.error)
            }
        })
        .catch(error => console.log(error))
        .finally(() => {
            console.log('success')
        })


</script>
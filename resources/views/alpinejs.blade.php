<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>To-Do на Alpine.js</title>
    <script
        src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.3.5/dist/alpine.min.js"
        defer
    ></script>
</head>
<body>
<style>
    .completed {
        text-decoration: line-through;
    }

    li {
        cursor: pointer;
    }
</style>

<div x-data="todos()" x-init="fetchTodos()">
    <div>
        <h4>Добавить новую задачу:</h4>
        <input type="text" x-model="inputValue" />
        <button @click="addTodo()">Добавить</button>
    </div>
    <h1>Планы на сегодня:</h1>
    <ul>
        <template x-for="todo in todos" :key="todo.id">
            <li @click="toggleTodo(todo.id)" :class="{'completed': todo.completed}">
                <span x-text="todo.title"></span>
                <span @click="deleteTodo(todo.id)">&times;</span>
            </li>
        </template>
    </ul>
</div>

<script>
    function todos() {
        return {
            todos: [],
            fetchTodos: function () {
                fetch('https://jsonplaceholder.typicode.com/todos')
                    .then((response) => response.json())
                    .then((data) => {
                        this.todos = data.slice(0, 10);
                    });
            },
            toggleTodo: function (id) {
                var todo = this.todos.find((todo) => todo.id === id);
                todo.completed = !todo.completed;
            },
            inputValue: '',
            addTodo: function () {
                if (!this.inputValue) {
                    return;
                }

                this.todos.push({
                    id: Date.now(),
                    title: this.inputValue,
                    completed: false,
                });
                this.inputValue = '';
            },
            deleteTodo: function (id) {
                this.todos = this.todos.filter((todo) => todo.id !== id);
            },
        };
    }
</script>
</body>
</html>

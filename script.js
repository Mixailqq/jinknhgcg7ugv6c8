// Обработка формы создания новой темы
document.addEventListener('DOMContentLoaded', function() {
    const topicForm = document.getElementById('topicForm');
    
    if (topicForm) {
        topicForm.addEventListener('submit', function(event) {
            event.preventDefault();
            
            // Получаем данные из формы
            const authorName = document.getElementById('authorName').value;
            const topicTitle = document.getElementById('topicTitle').value;
            const topicMessage = document.getElementById('topicMessage').value;
            
            // Создаем объект темы
            const newTopic = {
                author: authorName,
                title: topicTitle,
                message: topicMessage,
                timestamp: new Date().toLocaleString('ru-RU')
            };
            
            // Сохраняем тему в localStorage
            saveTopic(newTopic);
            
            // Очищаем форму и показываем сообщение об успехе
            topicForm.reset();
            alert('Тема успешно создана!');
        });
    }
});

// Функция для сохранения темы в localStorage
function saveTopic(topic) {
    // Получаем существующие темы или создаем пустой массив
    const existingTopics = JSON.parse(localStorage.getItem('forumTopics')) || [];
    
    // Добавляем новую тему
    existingTopics.push(topic);
    
    // Сохраняем обратно в localStorage
    localStorage.setItem('forumTopics', JSON.stringify(existingTopics));
}
# PORYADOK
### Industrial AI-Powered File Intelligence

**Poryadok** — это бескомпромиссное десктопное решение для тех, кто устал от цифрового хаоса. Это не просто «сортировщик файлов», это интеллектуальный слой между вами и вашей файловой системой, который понимает контекст данных и наводит порядок там, где человек бессилен.

---

## ⚡️ Почему Poryadok?

* **Neural Classification:** Забудьте про сортировку по расширениям. Наш ИИ анализирует содержимое документов и изображений, распределяя их по смысловым категориям.
* **Ink Monochrome UI:** Эксклюзивный «чернильный» интерфейс, спроектированный для максимальной концентрации. Никаких лишних цветов — только вы и ваши данные.
* **Local-First Privacy:** Ваши файлы не покидают компьютер. Приложение поддерживает локальные LLM (Ollama), обеспечивая полную приватность обработки.
* **Native Execution:** Благодаря NativePHP, приложение работает с производительностью нативного софта, имея прямой доступ к системным API.

---

## 🛠 Технологический стек

| Слой | Стек |
| :--- | :--- |
| **Runtime** | NativePHP (Laravel 11 + PHP 8.3) |
| **Frontend** | Vue 3 + Inertia.js (Composition API) |
| **Styling** | Tailwind CSS (Custom Industrial Theme) |
| **AI Layer** | Integration with Local/Cloud LLM |

---

## 🚀 Быстрый старт

Убедитесь, что у вас установлены PHP 8.3, Composer и Node.js.

1.  **Клонирование:**
    ```bash
    git clone [https://github.com/Donk1hong/Poryadok.git](https://github.com/Donk1hong/Poryadok.git)
    cd Poryadok
    ```

2.  **Backend:**
    ```bash
    composer install
    cp .env.example .env
    php artisan key:generate
    ```

3.  **Frontend:**
    ```bash
    npm install
    npm run build
    ```

4.  **Запуск NativePHP:**
    ```bash
    php artisan native:serve
    ```

---

## 🏗 Будущее проекта (Roadmap)

- [ ] **Smart Rules:** Создание собственных промптов для уникальных правил сортировки.
- [ ] **Background Watcher:** Автоматическая сортировка папки «Загрузки» в фоновом режиме.
- [ ] **Cloud Connect:** Поддержка анализа файлов в Google Drive и Dropbox через API.
- [ ] **Deep Search:** Поиск по смыслу содержимого файлов (Semantic Search).

## 📄 Лицензия

Распространяется под лицензией **MIT**. Полная свобода для личного и коммерческого использования.

---

**Designed with precision. Developed for order.**
*Created by Donk1hong*

import { createRoot } from 'react-dom/client';

const App = () => {
    return (
        <div>
            <h2>Welcome to My Plugin React Admin</h2>
            <p>This app can use WP REST API and translations.</p>
        </div>
    );
};

const container = document.getElementById('my-plugin-app');
if (container) {
    const root = createRoot(container);
    root.render(<App />);
}

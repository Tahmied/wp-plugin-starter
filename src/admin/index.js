console.log('running')
import { createRoot } from "@wordpress/element";

const App = () => {
    return (
        <div>
            <h2>Welcome to CartSheild React Admin</h2>
            <p className="bg-red text-3xl">This app is now connected!</p>
        </div>
    );
};

const container = document.getElementById('cartsheild-admin-app');

if (container) {
    const root = createRoot(container);
    root.render(<App />);
}
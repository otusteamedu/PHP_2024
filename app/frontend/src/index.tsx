import React from "react";
import ReactDOM from "react-dom/client";
import "primereact/resources/themes/lara-light-blue/theme.css"; // Тема (можно другую)
import "primereact/resources/primereact.min.css"; // Стили компонентов
import "primeicons/primeicons.css"; // Иконки
import "./index.css";
import App from "./App";
import reportWebVitals from "./reportWebVitals";
import { Provider } from "react-redux";
import store from "./redux/store";

const root = ReactDOM.createRoot(document.getElementById("root") as HTMLElement);

root.render(
  <React.StrictMode>
    <Provider store={store}>
      <App />
    </Provider>
  </React.StrictMode>
);

declare global {
  interface Window {
    store: typeof store;
  }
}

window.store = store;

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();

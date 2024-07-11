import './css/reset.css';
import './css/base.css';
import './css/App.css';
import './css/media.css';
import './css/fonts/PT_Root/stylesheet.css';
import Header from "./Components/Header";
import Footer from "./Components/Footer";
import React from "react";
import {BrowserRouter,Routes,Route, Navigate } from "react-router-dom";
import Main from "./Components/PagesExternal/MainPage/Main";
import NotFound from "./Components/PagesExternal/NotFound";

function App() {

  return (
    <div className="App">
            <BrowserRouter>
                <Header />
                <main>
                        <Routes>
                            <Route path="*" element={<NotFound />} />
                            <Route path="/" element={<Main />} />
                        </Routes>
                </main>
                <Footer />
            </BrowserRouter>
    </div>
  );
}

export default App;

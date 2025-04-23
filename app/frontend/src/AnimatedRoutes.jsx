import React from "react";
import { Routes, Route, useLocation } from "react-router-dom";
import { AnimatePresence } from "framer-motion";

import HomeComponent from "./Components/HomeComponent/HomeComponentContainer";
import UploadComponent from "./Components/UploadComponent/UploadComponentContainer";
import ParsingProgressComponent from "./Components/ParsingProgressComponent/ParsingProgressComponentContainer";

const AnimatedRoutes = () => {
  const location = useLocation();

  return (
    <AnimatePresence mode="wait">
      <div className="app-content">
        <Routes location={location} key={location.pathname}>
          <Route path="/" element={<HomeComponent />} />
          <Route path="/home" element={<HomeComponent />} />
          <Route path="/upload" element={<UploadComponent />} />
          <Route path="/progress" element={<ParsingProgressComponent />} />
        </Routes>
      </div>
    </AnimatePresence>
  );
};

export default AnimatedRoutes;

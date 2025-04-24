import { Card } from "primereact/card";
import { motion, AnimatePresence } from "framer-motion";
import { NavLink } from "react-router-dom";
import { Button } from "primereact/button";

const HomeComponent = (props) => {
  return (
    <AnimatePresence mode="wait">
      <motion.div
        key="home"
        initial={{ opacity: 0, y: 30 }}
        animate={{ opacity: 1, y: 0 }}
        exit={{ opacity: 0, y: -30 }}
        transition={{ duration: 0.6 }}
        style={{ width: "100%", display: "flex", justifyContent: "center", padding: "1rem 1.5rem" }}
      >
        <motion.div
          key="card"
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
          exit={{ opacity: 0 }}
          transition={{ duration: 0.6, delay: 0.3 }}
          style={{ width: "100%", maxWidth: "960px" }}
        >
          <Card
            title={<h2 style={{ marginBottom: "0.2rem" }}>Сервис парсинга судебных дел</h2>}
            subTitle={
              <span style={{ color: "#5c6f82", fontSize: "1rem" }}>
                Автоматический сбор и анализ судебной информации
              </span>
            }
            style={{
              width: "100%",
              borderRadius: "12px",
              boxShadow: "0 10px 25px rgba(0,0,0,0.08)",
              backgroundColor: "#ffffff",
              padding: "0.5rem 2rem",
            }}
            footer={
              <div className="p-d-flex p-jc-end">
                <NavLink to="/upload">
                  <Button
                    label="Перейти к загрузке дел"
                    icon="pi pi-arrow-right"
                    className="p-button-raised p-button-primary"
                  />
                </NavLink>
              </div>
            }
          >
            <div style={{ fontSize: "1.15rem", color: "#3b3b3b", lineHeight: "1.8" }}>
              <p>
                Добро пожаловать в инструмент мониторинга и анализа судебных дел. Мы поможем вам быстро получать
                актуальную информацию из открытых источников, включая:
              </p>
              <ul style={{ paddingLeft: "1.2rem", marginBottom: "1rem" }}>
                <li>Судьи и состав суда</li>
                <li>Участники дел</li>
                <li>Судебные заседания и их итоги</li>
                <li>Дата регистрации и статус дела</li>
              </ul>
              <p>Выберите раздел в меню сверху, чтобы начать работу, или нажмите на кнопку ниже.</p>
            </div>
          </Card>
        </motion.div>
      </motion.div>
    </AnimatePresence>
  );
};

export default HomeComponent;

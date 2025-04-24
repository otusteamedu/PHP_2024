import React, { useEffect, useState } from "react";
import { useLocation } from "react-router-dom";
import { Card } from "primereact/card";
import { Chart } from "primereact/chart";
import { ProgressBar } from "primereact/progressbar";
import { Button } from "primereact/button";
import { motion, AnimatePresence } from "framer-motion";
import { Accordion, AccordionTab } from "primereact/accordion";
import { Toast } from "primereact/toast";
import { Paginator } from "primereact/paginator";
import * as XLSX from "xlsx";
import { saveAs } from "file-saver";
import { formatDate } from "../../utils/formatDate";

const ParsingProgressComponent = (props) => {
  const { data: parsedData, linkCount, onCancel, getProgress } = props;
  const [parsedLinks, setParsedLinks] = useState(0);
  const [successCount, setSuccessCount] = useState(0);
  const [errorCount, setErrorCount] = useState(0);
  const [currentPageData, setCurrentPageData] = useState([]);
  const [progress, setProgress] = useState(0);
  const [parsing, setParsing] = useState(true);
  const [first, setFirst] = useState(0);
  const [rows, setRows] = useState(5);

  useEffect(() => {
    if (parsedData.length > 0) {
      setParsedLinks(parsedData.length);
      setCurrentPageData(parsedData.slice(first, first + rows));
      setSuccessCount(parsedData?.filter((item) => item.status === "success").length);
      setErrorCount(parsedData?.filter((item) => item.status === "error").length);
    }
  }, [parsedData, first, rows]);

  useEffect(() => {
    if (linkCount === 0) {
      setProgress(0);
      return;
    }

    const percent = Math.floor((parsedLinks / linkCount) * 100);
    setProgress(percent);

    if (percent >= 100) {
      setParsing(false);
    }
  }, [parsedLinks, linkCount]);

  const chartData = {
    labels: ["Успешно", "Ошибка"],
    datasets: [
      {
        data: [successCount, errorCount],
        backgroundColor: ["#4caf50", "#f44336"],
        hoverBackgroundColor: ["#66bb6a", "#e57373"],
      },
    ],
  };

  const chartOptions = {
    responsive: false,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: "bottom",
        align: "center",
        labels: {
          boxWidth: 20,
          padding: 10,
          usePointStyle: true,
        },
      },
    },
  };

  const errorCounts = {};
  if (parsedData.length > 0) {
    parsedData?.forEach((item) => {
      if (item.status === "error" && item.errorType) {
        errorCounts[item.errorType] = (errorCounts[item.errorType] || 0) + 1;
      }
    });
  }

  const chartDataErrors = {
    labels: Object.keys(errorCounts),
    datasets: [
      {
        data: Object.values(errorCounts),
        backgroundColor: ["#FFB347", "#7FDBB6", "#FF6961", "#FDFD96", "#77DD77"],
      },
    ],
  };

  const chartOptionsErrors = {
    responsive: false,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: "bottom",
        align: "center",
        labels: {
          boxWidth: 20,
          padding: 10,
          usePointStyle: true,
        },
      },
    },
  };

  const useOnReload = (callback, pathname) => {
    const location = useLocation();

    useEffect(() => {
      const isReload = performance.getEntriesByType("navigation")[0]?.type === "reload";

      if (isReload && location.pathname === pathname) {
        callback();
      }
    }, [location.pathname]);
  };

  useOnReload(() => {
    getProgress();
  }, "/progress");

  const onDownload = () => {
    const formattedData = parsedData.map((item) => {
      return {
        "Общий номер": item.generalNumber,
        "Номер дела": item.caseNumber,
        Суд: item.title,
        Судья: item.judgeFio,
        "Дата регистрации": item.registerDate,
        Ссылка: item.url,
        Статус: item.status,
        "Тип ошибки": item.errorType,
        ...(item.events?.length > 0 && {
          События: item.events
            .map((e) => `• ${e.resultDate} ${e.resultTime || ""} – ${e.title || ""} ${e.result && `(${e.result})`}`)
            .join("\n"),
        }),
        ...(item.parties?.length > 0 && {
          Участники: item.parties.map((p) => `${p.party_type}: ${p.patry_name}`).join("\n"),
        }),
      };
    });

    const worksheet = XLSX.utils.json_to_sheet(formattedData);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "Результаты парсинга");

    const excelBuffer = XLSX.write(workbook, {
      bookType: "xlsx",
      type: "array",
    });

    const blob = new Blob([excelBuffer], {
      type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
    });

    saveAs(blob, "parsed-data.xlsx");
  };

  return (
    <AnimatePresence mode="wait">
      <motion.div
        key="progress"
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
            title={<h2 style={{ marginBottom: "0.2rem" }}>Прогресс парсинга</h2>}
            subTitle={<span style={{ color: "#5c6f82" }}>Следим за ходом анализа судебных дел</span>}
            style={{
              width: "100%",
              borderRadius: "12px",
              boxShadow: "0 10px 25px rgba(0,0,0,0.08)",
              backgroundColor: "#ffffff",
              padding: "0.5rem 2rem",
            }}
            footer={
              <div className="flex justify-content-end flex-wrap gap-2">
                {/* <div>
                  <Button label="Скачать" icon="pi pi-download" className="p-button-success" onClick={onDownload} />
                </div> */}
                {/* <div> */}
                {parsing ? (
                  <div className="flex justify-content-end">
                    <Button label="Отменить" icon="pi pi-times" className="p-button-danger" onClick={onCancel} />
                  </div>
                ) : (
                  <div className="flex justify-content-end">
                    <Button label="Скачать" icon="pi pi-download" className="p-button-success" onClick={onDownload} />
                  </div>
                )}
                {/* </div> */}
              </div>
            }
          >
            <div style={{ fontSize: "1.1rem", color: "#3b3b3b" }}>
              <p>
                Обработано {parsedLinks} из {linkCount} ссылок
              </p>
              <ProgressBar value={progress} showValue unit="%" style={{ height: "1.5rem" }} />
            </div>

            <div style={{ marginTop: "2rem" }}>
              {parsedData.length > 0 && (
                <div>
                  <Accordion>
                    <AccordionTab
                      header={
                        <span style={{ display: "flex", alignItems: "center", gap: "0.5rem" }}>
                          <i className="pi pi-chart-pie" style={{ fontSize: "1.2rem", color: "#3f51b5" }} />
                          Статистика парсинга
                        </span>
                      }
                    >
                      <div
                        style={{
                          // marginTop: "2rem",
                          display: "flex",
                          flexDirection: "row",
                          justifyContent: "space-evenly",
                          // gap: "14rem", // расстояние между графиками
                          flexWrap: "wrap", // на случай, если не влезает в одну строку
                        }}
                      >
                        <div style={{ display: "flex", flexDirection: "column", alignItems: "center" }}>
                          <h4>Общая статистика</h4>
                          <Chart
                            type="pie"
                            data={chartData}
                            options={chartOptions}
                            style={{ width: "300px", maxHeight: "200px" }}
                            width={300}
                            height={200}
                          />
                        </div>
                        <div style={{ display: "flex", flexDirection: "column", alignItems: "center" }}>
                          <h4>Статистика ошибок</h4>
                          <Chart
                            type="pie"
                            data={chartDataErrors}
                            options={chartOptionsErrors}
                            style={{ width: "300px", maxHeight: "200px" }}
                            width={300}
                            height={200}
                          />
                        </div>
                      </div>
                    </AccordionTab>
                  </Accordion>
                  <Accordion>
                    <AccordionTab
                      header={
                        <span style={{ display: "flex", alignItems: "center", gap: "0.5rem" }}>
                          <i className="pi pi-folder-open" style={{ fontSize: "1.2rem", color: "#3f51b5" }} />
                          Подробная информация
                        </span>
                      }
                    >
                      <div
                        style={{
                          maxHeight: "600px", // можно настроить под себя
                          overflowY: "auto",
                          paddingRight: "1rem", // чтобы не пряталась часть контента за скроллом
                        }}
                      >
                        <Accordion>
                          {currentPageData.map((data, index) => {
                            if (data.status === "error") {
                              return (
                                <AccordionTab
                                  key={first + index}
                                  header={
                                    <div
                                      style={{
                                        display: "flex",
                                        justifyContent: "space-between",
                                        alignItems: "center",
                                        width: "100%",
                                      }}
                                    >
                                      <span>Ошибка парсинга</span>
                                      <i
                                        className="pi pi-times-circle"
                                        title="Ошибка парсинга"
                                        style={{ color: "red", fontSize: "1.2rem", marginLeft: "1rem" }}
                                      />
                                    </div>
                                  }
                                >
                                  <div>
                                    <div style={{ fontSize: "1.1rem", color: "#3b3b3b" }}>
                                      <strong>Тип ошибки:</strong> {data.errorType}
                                    </div>
                                    <div>
                                      <strong>Ссылка:</strong>{" "}
                                      <a
                                        href={data.url}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        style={{
                                          color: "#7a7a7a",
                                          textDecoration: "none",
                                          fontWeight: "500",
                                          wordBreak: "break-word",
                                          transition: "color 0.2s, text-decoration 0.2s",
                                        }}
                                        onMouseEnter={(e) => {
                                          e.currentTarget.style.color = "#5a5a5a";
                                          e.currentTarget.style.textDecoration = "underline";
                                        }}
                                        onMouseLeave={(e) => {
                                          e.currentTarget.style.color = "#7a7a7a";
                                          e.currentTarget.style.textDecoration = "none";
                                        }}
                                      >
                                        {data.url}
                                      </a>
                                    </div>
                                  </div>
                                </AccordionTab>
                              );
                            } else {
                              return (
                                <AccordionTab
                                  key={first + index}
                                  header={
                                    <div
                                      style={{
                                        display: "flex",
                                        justifyContent: "space-between",
                                        alignItems: "center",
                                        width: "100%",
                                      }}
                                    >
                                      <span>Дело № {data.caseNumber}</span>
                                      <i
                                        className="pi pi-check-circle"
                                        title="Парсинг завершён"
                                        style={{ color: "green", fontSize: "1.2rem", marginLeft: "1rem" }}
                                      />
                                    </div>
                                  }
                                >
                                  <div>
                                    <div>
                                      <strong>Суд:</strong> {data.title}
                                    </div>
                                    <div>
                                      <strong>Номер дела:</strong> {data.caseNumber}
                                    </div>
                                    <div>
                                      <strong>Судья:</strong> {data.judgeFio}
                                    </div>
                                    <div>
                                      <strong>Дата регистрации:</strong> {formatDate(data.registerDate)}
                                    </div>
                                    <div>
                                      <strong>Ссылка:</strong>{" "}
                                      <a
                                        href={data.url}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        style={{
                                          color: "#7a7a7a",
                                          textDecoration: "none",
                                          fontWeight: "500",
                                          wordBreak: "break-word",
                                          transition: "color 0.2s, text-decoration 0.2s",
                                        }}
                                        onMouseEnter={(e) => {
                                          e.currentTarget.style.color = "#5a5a5a";
                                          e.currentTarget.style.textDecoration = "underline";
                                        }}
                                        onMouseLeave={(e) => {
                                          e.currentTarget.style.color = "#7a7a7a";
                                          e.currentTarget.style.textDecoration = "none";
                                        }}
                                      >
                                        {data.url}
                                      </a>
                                    </div>

                                    <div style={{ marginTop: "1rem" }}>
                                      <Accordion>
                                        <AccordionTab header="События">
                                          {data.events.length > 0 ? (
                                            data.events.map((event, idx) => (
                                              <div
                                                key={idx}
                                                style={{
                                                  marginBottom: "1rem",
                                                  padding: "0.75rem",
                                                  border: "1px solid #ddd",
                                                  borderRadius: "8px",
                                                  backgroundColor: "#f9f9f9",
                                                }}
                                              >
                                                <div>
                                                  <strong>Название:</strong> {event.title}
                                                </div>
                                                <div>
                                                  <strong>Дата:</strong> {formatDate(event.resultDate)}
                                                </div>
                                                <div>
                                                  <strong>Время:</strong> {event.resultTime}
                                                </div>
                                                <div>
                                                  <strong>Место:</strong> {event.location}
                                                </div>
                                                <div>
                                                  <strong>Результат:</strong> {event.result}
                                                </div>
                                                <div>
                                                  <strong>Основание:</strong> {event.basis}
                                                </div>
                                                <div>
                                                  <strong>Примечания:</strong> {event.notes}
                                                </div>
                                                <div>
                                                  <strong>Дата публикации:</strong> {formatDate(event.postingDate)}
                                                </div>
                                              </div>
                                            ))
                                          ) : (
                                            <div>Нет событий</div>
                                          )}
                                        </AccordionTab>
                                        <AccordionTab header="Стороны">
                                          {data.parties.length > 0 ? (
                                            data.parties.map((party, idx) => (
                                              <div
                                                key={idx}
                                                style={{
                                                  marginBottom: "0.75rem",
                                                  padding: "0.75rem",
                                                  border: "1px solid #ddd",
                                                  borderRadius: "8px",
                                                  backgroundColor: "#f9f9f9",
                                                }}
                                              >
                                                <div>
                                                  <strong>Тип участника:</strong> {party.party_type}
                                                </div>
                                                <div>
                                                  <strong>Имя:</strong> {party.patry_name}
                                                </div>
                                              </div>
                                            ))
                                          ) : (
                                            <div>Нет участников</div>
                                          )}
                                        </AccordionTab>
                                      </Accordion>
                                    </div>
                                  </div>
                                </AccordionTab>
                              );
                            }
                          })}
                        </Accordion>
                      </div>
                      <div style={{ marginTop: "1.5rem" }}>
                        <Paginator
                          first={first}
                          rows={rows}
                          template="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                          currentPageReportTemplate="{first} - {last} / {totalRecords}"
                          rowsPerPageOptions={[5, 10, 25, 50, 100]}
                          totalRecords={parsedData.length}
                          onPageChange={(e) => {
                            setFirst(e.first);
                            setRows(e.rows);
                          }}
                        />
                      </div>
                    </AccordionTab>
                  </Accordion>
                </div>
              )}
            </div>
          </Card>
        </motion.div>
      </motion.div>
    </AnimatePresence>
  );
};

export default ParsingProgressComponent;

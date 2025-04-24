import React, { useRef, useState } from "react";
import { Card } from "primereact/card";
import { Toast } from "primereact/toast";
import { FileUpload } from "primereact/fileupload";
import { Button } from "primereact/button";
import { Dialog } from "primereact/dialog";
import { DataTable } from "primereact/datatable";
import { Column } from "primereact/column";
import * as XLSX from "xlsx";
import { motion, AnimatePresence } from "framer-motion";

const UploadComponent = ({ uploadData }) => {
  const toast = useRef(null);
  const [jsonData, setJsonData] = useState([]);
  const [showDialog, setShowDialog] = useState(false);

  const makeJSONDataFile = (file) => {
    return new Promise((resolve, reject) => {
      const fileReader = new FileReader();
      fileReader.readAsArrayBuffer(file);

      fileReader.onload = (e) => {
        try {
          const loadData = e.target.result;
          const workbook = XLSX.read(loadData, { type: "binary" });
          const firstSheetName = workbook.SheetNames[0];
          const sheet = workbook.Sheets[firstSheetName];

          const customHeaders = ["generalNumber", "url"];
          const data = XLSX.utils.sheet_to_json(sheet, {
            header: customHeaders,
            range: 0,
          });

          resolve(data);
        } catch (error) {
          reject(error);
        }
      };
    });
  };

  const onSelect = async (e) => {
    const [file] = e.files;

    try {
      const parsedData = await makeJSONDataFile(file);
      setJsonData(parsedData);
      toast.current.show({
        severity: "success",
        summary: "Файл загружен",
        detail: `Обнаружено строк: ${parsedData.length}`,
        life: 3000,
      });
    } catch {
      toast.current.show({
        severity: "error",
        summary: "Ошибка чтения",
        detail: "Проверьте формат файла.",
        life: 5000,
      });
    }
  };

  const onUpload = () => {
    uploadData(jsonData);
    toast.current.show({
      severity: "info",
      summary: "Загрузка завершена",
      detail: "Данные переданы в систему",
      life: 3000,
    });
  };

  return (
    <AnimatePresence mode="wait">
      <motion.div
        key="upload"
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
          <Toast ref={toast} />
          <Card
            title={<h2 style={{ marginBottom: "0.2rem" }}>Загрузка Excel-файла</h2>}
            subTitle={
              <span style={{ color: "#5c6f82", fontSize: "1rem" }}>
                Выберите файл со списком дел в формате Excel (.xlsx или .xls)
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
              <div className="flex justify-content-between align-items-center gap-2">
                <Button
                  label="Посмотреть данные"
                  icon="pi pi-eye"
                  className="p-button-outlined"
                  onClick={() => setShowDialog(true)}
                  disabled={!jsonData.length}
                />
                <Button
                  label="Загрузить"
                  icon="pi pi-upload"
                  className="p-button-raised p-button-success"
                  onClick={onUpload}
                  disabled={!jsonData.length}
                />
              </div>
            }
          >
            <div className="flex flex-column gap-4">
              <FileUpload
                mode="basic"
                name="upload[]"
                accept=".xlsx, .xls"
                maxFileSize={10000000}
                auto={false}
                chooseLabel="Выбрать файл"
                onSelect={onSelect}
                className="w-full"
              />
            </div>
          </Card>

          <Dialog
            header="Просмотр загруженных данных"
            visible={showDialog}
            onHide={() => setShowDialog(false)}
            modal
            style={{ width: "90vw", maxWidth: "1000px" }}
            breakpoints={{ "960px": "95vw" }}
          >
            <DataTable
              value={jsonData}
              paginator
              paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
              currentPageReportTemplate="Показаны с {first} по {last} из {totalRecords} объектов"
              rowsPerPageOptions={[5, 10, 25, 50, 100]}
              rows={5}
              emptyMessage="Нет загруженных данных"
              stripedRows
              scrollable
              scrollHeight="400px"
            >
              <Column field="generalNumber" header="Номер дела" style={{ minWidth: "150px" }} />
              <Column
                header="Ссылка"
                style={{ minWidth: "300px" }}
                body={(rowData) => (
                  <a
                    href={rowData.url}
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
                    {rowData.url}
                  </a>
                )}
              />
            </DataTable>
          </Dialog>
        </motion.div>
      </motion.div>
    </AnimatePresence>
  );
};

export default UploadComponent;

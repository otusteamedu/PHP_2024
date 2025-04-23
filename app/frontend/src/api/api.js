import axios from "axios";

const instance = axios.create({
  withCredentials: true,
  baseURL: "/",
  headers: {
    "Content-Type": "application/json",
  },
});

export const DataAPI = {
  async getProgress() {
    const responce = await instance.get(`api/ready`);
    return responce.data;
  },
  async getStatus() {
    const responce = await instance.get(`api/status`);
    return responce.data;
  },
  async updateStatus(status) {
    const responce = await instance.post(`api/status`, { status });
    return responce.data;
  },
  async upload(data) {
    try {
      const responce = await instance.post(`api/upload`, { data });
      return responce.data;
    } catch (error) {
      throw error;
    }
  },
};

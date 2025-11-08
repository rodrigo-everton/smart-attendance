import axios from "axios";

const api = axios.create({
  baseURL: "localhost:8000", // substitua pela sua URL
  timeout: 5000,
});

export default api;

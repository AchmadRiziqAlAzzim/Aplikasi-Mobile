import axios from 'axios';
const API_URL = 'http://localhost/aplikasi/server/api.php';

export const getUsers = async () => {
  try {
    const res = await axios.get(API_URL);
    return res.data;
  } catch (error) {
    console.error('Error fetching users:', error);
    throw error;
  }
};

export const addUser = async (data) => {
  try {
    const res = await axios.post(API_URL, data);
    return res.data;
  } catch (error) {
    console.error('Error adding user:', error);
    throw error;
  }
};

export const updateUser = async (id, data) => {
  try {
    const res = await axios.put(`${API_URL}?id=${id}`, data);
    return res.data;
  } catch (error) {
    console.error('Error updating user:', error);
    throw error;
  }
};

export const deleteUser = async (id) => {
  try {
    const res = await axios.delete(`${API_URL}?id=${id}`);
    return res.data;
  } catch (error) {
    console.error('Error deleting user:', error);
    throw error;
  }
};

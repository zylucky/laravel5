import axios from 'axios';
let base = '';

export const requestLogin = params => { return axios.post(`${base}/login`, params).then(res => res.data); };
export const logout = params => { return axios.post(`${base}/logout`, params).then(res => res.data); };
export const getUserListPage = params => { return axios.post(`${base}/user/list`, { params: params }); };

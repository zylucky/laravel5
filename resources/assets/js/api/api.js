import axios from 'axios';
let base = '';
let omc = 'http://121.196.195.129:8557';

export const requestLogin = params => { return axios.post(`${base}/login`, params).then(res => res.data); };
export const logout = params => { return axios.post(`${base}/logout`, params).then(res => res.data); };

export const getUserListPage = params => { return axios.get(`${base}/user/list`, { params: params }); };
export const removeUser = params => { return axios.post(`${base}/user/delete`, { params: params }); };
export const addUser = params => { return axios.post(`${base}/user/store`, { params: params }); };
export const editUser = params => { return axios.post(`${base}/user/edit`, { params: params }); };
export const batchRemoveUser = params => { return axios.post(`${base}/user/batchRemoveUser`, { params: params }); };

export const getRoleListPage = params => { return axios.get(`${base}/role`, { params: params }); };
export const removeRole = params => { return axios.delete(`${base}/role/`+params.id, {}); };
export const addRole = params => { return axios.post(`${base}/role`, { params: params }); };
export const editRole = params => { return axios.put(`${base}/role/`+params.id, { params: params }); };
export const batchRemoveRole = params => { return axios.post(`${base}/user/batchRemoveUser`, { params: params }); };
export const getTotalRoleList = params => { return axios.get(`${base}/role/create`, { params: params }); };
export const getRoleList = params => { return axios.get(`${base}/role/`+params.id, { params: params }); };
export const setRoleList = params => { return axios.post(`${base}/user/role/`+params.id, { params: params }); };

export const getBrokerCompanyListPage = params => { return axios.get(`${base}/brokerCompany`, { params: params }); };
export const removeBrokerCompany = params => { return axios.delete(`${base}/brokerCompany/`+params.id, {}); };
export const addBrokerCompany = params => { return axios.post(`${base}/brokerCompany`, { params: params }); };
export const editBrokerCompany = params => { return axios.put(`${base}/brokerCompany/`+params.tQdCompayId, { params: params }); };
export const batchRemoveBrokerCompany = params => { return axios.post(`${base}/brokerCompany/batchRemoveBrokerCompany`, { params: params }); };

export const getBrokerCompanyUserListPage = params => { return axios.get(`${base}/brokerCompanyUser`, { params: params }); };
export const removeBrokerCompanyUser = params => { return axios.delete(`${base}/brokerCompanyUser/`+params.id, {}); };
export const addBrokerCompanyUser = params => { return axios.post(`${base}/brokerCompanyUser`, { params: params }); };
export const editBrokerCompanyUser = params => { return axios.put(`${base}/brokerCompanyUser/`+params.id, { params: params }); };
export const batchRemoveBrokerCompanyUser = params => { return axios.post(`${base}/brokerCompanyUser/batchRemoveBKUser`, { params: params }); };
export const getbkNameList = params =>{ return axios.post(`${base}/brokerCompanyUser/getbkNameList`, { params: params }); };
export const checkbkNameList = params =>{ return axios.post(`${base}/brokerCompany/checkbkNameList`, { params: params }); };
export const getUserById = params =>{ return axios.post(`${base}/brokerCompany/getUserById`, { params: params }); };

export const getChuFangCommissionListPage = params => { return axios.get(`${base}/chuFangCommission`, { params: params }); };

export const getShouFangCommissionListPage = params => { return axios.get(`${base}/shouFangCommission`, { params: params }); };

export const selectCommissionPayType = params => { return axios.post(`${base}/Commission/contractPayType`, { params: params }); };

export const getReceivableListPage = params => { return axios.get(`${base}/receivable`, { params: params }); };
export const editReceivable = params => { return axios.put(`${base}/receivable/`+params.id, { params: params }); };
export const saveShouKuan = params => { return axios.post(`${base}/receivable/saveShouKuan` , { params: params }); };

export const getReceivableRecordListPage = params => { return axios.get(`${base}/receivableRecord`, { params: params }); };

export const getAccountsReceivableListPage = params => { return axios.get(`${base}/accountsReceivable`, { params: params }); };
export const addReceivable = params => { return axios.post(`${base}/accountsReceivable`, { params: params }); };
export const removeReceivable = params => { return axios.delete(`${base}/accountsReceivable/`+params.id, {}); };

//查系统所有的权限
export const getPermissionListPage = params => { return axios.get(`${base}/permission/getAll`, { params: params }); };
//查XX的权限
export const getPermissionListOfRole = params => { return axios.get(`${base}/permission/role/`+params.id, {}); };
//查寻当前用户的权限
export const getPermissionList = params => { return axios.get(`${base}/permission/list`, { params: params }); };
export const setPermissionList = params => { return axios.post(`${base}/permission/update/`+params.id, { params: params }); };

//合同信息
export const addPurchaseContractInfo= params => { return axios.post(`${base}/purchaseContract`, { params: params }); };
export const reviewPurchaseContract= params => { return axios.post(`${base}/purchaseContract/review`, { params: params }); };
export const getPurchaseContractList = params => { return axios.get(`${base}/purchaseContract`, { params: params }); };
export const getPurchaseContractInfo = params => { return axios.get(`${base}/purchaseContract/`+params.id, {}); };
export const submitPurchaseContract = params => { return axios.get(`${base}/purchaseContract/`+params.id+'/edit', {}); };
export const getPurchaseContractTiaoKuan = params => { return axios.get(`${base}/purchaseContract/create`, {}); };
export const editPurchaseContractTiaoKuan= params => { return axios.post(`${base}/purchaseContract/editTiaoKuan`, { params: params }); };
export const confirmPurchaseContract= params => { return axios.get(`${base}/purchaseContract/confirm`, {params:params}); };
export const optimizePurchaseContract= params => { return axios.put(`${base}/purchaseContract/`, {params:params}); };//二次优化
//出房合同
//合同信息
export const addSaleContractInfo= params => { return axios.post(`${base}/saleContract`, { params: params }); };
export const reviewSaleContract= params => { return axios.post(`${base}/saleContract/review`, { params: params }); };
export const getSaleContractList = params => { return axios.get(`${base}/saleContract`, { params: params }); };
export const getSaleContractInfo = params => { return axios.get(`${base}/saleContract/`+params.id, {}); };
export const submitSaleContract = params => {return axios.get(`${base}/saleContract/`+params.id+'/edit', {}); };
export const jieyueSaleContractInfo = params => { return axios.post(`${base}/saleContract/sub`, { params: params }); };
export const getJieyueSaleContractInfo = params => { return axios.get(`${base}/saleContract/sub`+params.id, {}); };



export const removeSaleContract = params => { return axios.post(`${base}/saleContract/delete`, { params: params }); };



//获取楼盘，楼栋，房间号
export const getLoupanList = params =>{ return axios.get(`${base}/office/loupanList`, { params: params }); };
export const getLoudongList = params =>{ return axios.get(`${base}/office/loudongList`, { params: params }); };
export const getFanghaoList = params =>{ return axios.get(`${base}/office/fanghaoList`, { params: params }); };


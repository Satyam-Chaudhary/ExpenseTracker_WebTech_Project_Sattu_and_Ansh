const dateRecord = new Date();

const date = dateRecord.getDate();
const month = dateRecord.getMonth() + 1;
const year = dateRecord.getFullYear();
const spread = `${date}-${month}-${year}`

export default spread;
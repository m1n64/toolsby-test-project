export default interface IResponse<resp> {
    success: boolean,
    message: string,
    data: resp
}

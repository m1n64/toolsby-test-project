import Alpine from 'alpinejs';
import IPallets from "../interfaces/pallets.interface";
import axios, {AxiosResponse} from "axios";
import IResponse from "../interfaces/response.interface";
import Toast from "../components/toast";
import IFinalSum from "../interfaces/finalSum.interface";

const API_ENDPOINT = "/api/flights";

Alpine.data("indexPage", ()=>({
    palletsInfo: <IPallets[]>[],
    finalSumInfo: <IFinalSum[]>[],

    init() : void {
        axios.get(API_ENDPOINT+"/pallets")
            .then((response: AxiosResponse<IResponse<IPallets[]>>) => {
                if (!response.data.success) return Toast.showToast("Can't loaded pallets");

                this.palletsInfo = response.data.data;
            });

        axios.get(API_ENDPOINT+"/final")
            .then((response: AxiosResponse<IResponse<IFinalSum[]>>) => {
                if (!response.data.success) return Toast.showToast("Can't loaded final sum");

                this.finalSumInfo = response.data.data;
            })
    },

    scrollTo(elemId: string) : void {
        document.querySelector(elemId)?.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        })
    }

}));

Alpine.start();

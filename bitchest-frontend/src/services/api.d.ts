
declare module '../services/api' {

  export const authAPI: {

    logout(): Promise<void>;

  };



  export const marketAPI: {

    getStatistics(): Promise<any>;

    getCryptocurrencies(): Promise<any[]>;

    getRecentTransactions(): Promise<any[]>;

    getNotifications(): Promise<any[]>;

    getPriceHistory(symbol: string, interval: string): Promise<any[]>;

  };

}


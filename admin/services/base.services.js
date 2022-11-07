import axios, { AxiosInstance } from 'axios';

const baseService = class BaseService
{
    baseURL = null
    headers
    $http = AxiosInstance

    constructor ()
    {
        this.baseURL = process.env.API_URL

        this.headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }

        this.$http = axios.create( {
            timeout: 1600000
        } );

        this.$http.interceptors.request.use( ( config ) =>
        {
            return config
        } )

        this.$http.interceptors.response.use( ( response ) =>
        {
            return response
        }, error=>{
            if (error.response.status === 401) {
                localStorage.removeItem('auth_token');
                location.replace('/login')
            } else {
                return Promise.reject(error)
            }
        } )
    }

    getHeaders( additionalHeaders = {}, multipart = false )
    {

        const defaultHeaders = this.headers;

        const authToken = localStorage.getItem( 'auth_token' )

        if ( authToken ){
            defaultHeaders.Authorization = `Bearer ${ authToken }`
        }

        return {
            ...defaultHeaders,
            ...additionalHeaders
        }
    }

    getQueryString( params = {} )
    {
        return (
            Object
                .keys( params )
                .map( k => encodeURIComponent( k ) + '=' + encodeURIComponent( params[ k ] ) )
                .join( '&' )
        )
    }

    post( uri, data = {}, additionalHeaders = {} )
    {
        return this.$http.post( uri, data, {
            headers: this.getHeaders( additionalHeaders ),
        } )
    }

    remove( uri, data = {}, additionalHeaders = {} )
    {
        return this.$http( uri, {
            method: 'DELETE',
            headers: this.getHeaders( additionalHeaders ),
            data: data
        } )
    }

    put( uri, data, additionalHeaders = {} )
    {
        return this.$http.put( uri, data, {
            headers: this.getHeaders( additionalHeaders ),
        } )
    }

    patch( uri, data, additionalHeaders = {} )
    {
        return this.$http.patch( uri, data, {
            headers: this.getHeaders( additionalHeaders ),
        } )
    }



    get( uri, data = {}, additionalHeaders = {} )
    {
        if ( Object.keys( data ).length > 0 )
        {
            uri = `${ uri }?${ this.getQueryString( data ) }&branch_id=${localStorage.getItem('branch')}&location_id=${localStorage.getItem('location')}`
        } else if (localStorage.getItem('branch')) {
                uri += `?branch_id=${localStorage.getItem('branch')}&location_id=${localStorage.getItem('location')}`
        }

        return this.$http.get( uri, {
            headers: this.getHeaders( additionalHeaders ),
        } )

        // return this.$axios.$get(`${this.baseURL}/payments`, {
        //     headers: this.getHeaders(),
        // })
    }
};

export default baseService

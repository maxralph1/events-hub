import { useState, useEffect } from 'react'
 
export function useCountries() {
    const [countries, setCountries] = useState([])
    
    useEffect(() => {
        const controller = new AbortController()
        getCountries({ signal: controller.signal })
        return () => { controller.abort() }
    }, [])
    
    async function getCountries({ signal } = {}) {
        return axios.get('super-admin/countries', { signal })
        .then(response => setCountries(response.data.data))
        .catch(() => {})
    }
    
    return { countries, getCountries }
}
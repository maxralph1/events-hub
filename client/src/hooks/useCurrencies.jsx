import { useState, useEffect } from 'react'
import { useAuth } from '@/hooks/useAuth'
 
export function useCurrencies() {
    const [currencies, setCurrencies] = useState([])
    const { isAuthenticated, isSuperAdmin, isAdmin, logout } = useAuth()
    
    useEffect(() => {
        const controller = new AbortController()
        getCurrencies({ signal: controller.signal })
        return () => { controller.abort() }
    }, [])
    
    async function getCurrencies({ signal } = {}) {
        // return axios.get(`${isSuperAdmin ? 'super-admin/currencies' : isAdmin ? 'admin/currencies' : 'user/currencies'}`, { signal })
        return axios.get('super-admin/currencies', { signal })
        .then(response => setCurrencies(response.data.data))
        .catch(() => {})
    }
    
    return { currencies, getCurrencies }
}
// `${isSuperAdmin ? 'super-admin/currencies' : 'admin/currencies'}`
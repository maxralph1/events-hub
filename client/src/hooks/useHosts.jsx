import { useState, useEffect } from 'react'
 
export function useHosts() {
    const [hosts, setHosts] = useState([])
    
    useEffect(() => {
        const controller = new AbortController()
        getHosts({ signal: controller.signal })
        return () => { controller.abort() }
    }, [])
    
    async function getHosts({ signal } = {}) {
        return axios.get('super-admin/hosts', { signal })
        .then(response => setHosts(response.data.data))
        .catch(() => {})
    }
    
    return { hosts, getHosts }
}
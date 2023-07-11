import { useState, useEffect } from 'react'
 
export function useNewsletters() {
    const [newsletters, setNewsletters] = useState([])
    
    useEffect(() => {
        const controller = new AbortController()
        getNewsletters({ signal: controller.signal })
        return () => { controller.abort() }
    }, [])
    
    async function getNewsletters({ signal } = {}) {
        return axios.get('super-admin/newsletters', { signal })
        .then(response => setNewsletters(response.data.data))
        .catch(() => {})
    }
    
    return { newsletters, getNewsletters }
}
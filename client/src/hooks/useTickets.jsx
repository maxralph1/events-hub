import { useState, useEffect } from 'react'
 
export function useTickets() {
    const [tickets, setTickets] = useState([])
    
    useEffect(() => {
        const controller = new AbortController()
        getTickets({ signal: controller.signal })
        return () => { controller.abort() }
    }, [])
    
    async function getTickets({ signal } = {}) {
        return axios.get('super-admin/tickets', { signal })
        .then(response => setTickets(response.data.data))
        .catch(() => {})
    }
    
    return { tickets, getTickets }
}
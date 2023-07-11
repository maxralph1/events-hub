import { useState, useEffect } from 'react'
 
export function useTicketTypes() {
    const [ticketTypes, setTicketTypes] = useState([])
    
    useEffect(() => {
        const controller = new AbortController()
        getTicketTypes({ signal: controller.signal })
        return () => { controller.abort() }
    }, [])
    
    async function getTicketTypes({ signal } = {}) {
        return axios.get('super-admin/ticket-types', { signal })
        .then(response => setTicketTypes(response.data.data))
        .catch(() => {})
    }
    
    return { ticketTypes, getTicketTypes }
}
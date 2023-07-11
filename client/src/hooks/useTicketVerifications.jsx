import { useState, useEffect } from 'react'
 
export function useTicketVerifications() {
    const [ticketVerifications, setTicketVerifications] = useState([])
    
    useEffect(() => {
        const controller = new AbortController()
        getTicketVerifications({ signal: controller.signal })
        return () => { controller.abort() }
    }, [])
    
    async function getTicketVerifications({ signal } = {}) {
        return axios.get('super-admin/ticket-verifications', { signal })
        .then(response => setTicketVerifications(response.data.data))
        .catch(() => {})
    }
    
    return { ticketVerifications, getTicketVerifications }
}
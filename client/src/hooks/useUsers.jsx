import { useState, useEffect } from 'react'
 
export function useUsers() {
    const [users, setUsers] = useState([])
    
    useEffect(() => {
        const controller = new AbortController()
        getUsers({ signal: controller.signal })
        return () => { controller.abort() }
    }, [])
    
    async function getUsers({ signal } = {}) {
        return axios.get('super-admin/users', { signal })
        .then(response => setUsers(response.data.data))
        .catch(() => {})
    }
    
    return { users, getUsers }
}
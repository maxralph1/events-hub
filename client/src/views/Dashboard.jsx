import { useAuth } from '@/hooks/useAuth'
import { useEffect, useState } from 'react'
import { Link } from 'react-router-dom'
import { useEvents } from '@/hooks/useEvents'
import { useEvent } from '@/hooks/useEvent'
import { route } from '@/routes'

const Dashboard = () => {
    const { isAuthenticated, isGenericUser, logout } = useAuth()
    const { events, getEvents } = useEvents()
    const { destroyEvent } = useEvent()

    const [items, setItems] = useState([]);

    axios.interceptors.response.use(
        response => response,
        error => {
        if (error.response?.status === 401) logout(true)
        return Promise.reject(error)
        },
    )

    useEffect(() => {
        const items = JSON.parse(localStorage.getItem('role'));
        if (items) {
            setItems(items);
        }
    }, []);

    return (
        <div>Dashboard
            {/* {console.log(items)}
            {console.log(isAuthenticated)}
            {console.log(isGenericUser)} */}

            <Link to={ route('events.index') } className="">
                All Events
            </Link>


            <div className="">
                { events.length > 0 && events.map(event => {
                return (
                    <div
                    key={ event.id }
                    className=""
                    >
                        <div className="">
                            <div className="">
                            { event.title }
                            </div>
                            <div className="">
                            { event.description }
                            </div>
                        </div>
                        <div className="flex gap-1">
                            {/* <Link
                            to={ route('events.edit', { id: event.id }) }
                            className=""
                            >
                            Edit
                            </Link> */}
                            <button
                            type="button"
                            className=""
                            onClick={ async () => {
                                await destroyEvent(event)
                                await getEvents()
                            } }
                            >
                            X
                            </button>
                        </div>
                    </div>
                )
                })}
            </div>
        </div>
    )
}

export default Dashboard
import { Link } from 'react-router-dom'
import { route } from '@/routes'
import { useEventHalls } from '@/hooks/useEventHalls'
import { useEventHall } from '@/hooks/useEventHall'
 
function EventHallsList() {
    const { eventHalls, getEventHalls } = useEventHalls()
    const { destroyEventHall } = useEventHall()
    
    return (
        <div className="">
    
            <h1 className="">EventHalls</h1>
        
            <Link to={ route('eventHalls.create') } className="">
                Add EventHall
            </Link>
        
            <div className="border-t h-[1px] my-6"></div>
        
            <div className="">
                { eventHalls.length > 0 && eventHalls.map(eventHall => {
                return (
                    <div
                    key={ eventHall.id }
                    className=""
                    >
                        <div className="">
                            <div className="">
                                { eventHall.name }
                            </div>
                            <div className="">
                                { eventHall.description }
                            </div>
                        </div>
                        <div className="flex gap-1">
                            <Link
                                to={ route('eventHalls.edit', { id: eventHall.id }) }
                                className=""
                            >
                            Edit
                            </Link>
                            <button
                                type="button"
                                className=""
                                onClick={ async () => {
                                    await destroyEventHall(eventHall)
                                    await getEventHalls()
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
 
export default EventHallsList
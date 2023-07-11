import { Link } from 'react-router-dom'
import { route } from '@/routes'
import { useHosts } from '@/hooks/useHosts'
import { useHost } from '@/hooks/useHost'
 
function HostsList() {
    const { hosts, getHosts } = useHosts()
    const { destroyHost } = useHost()
    
    return (
        <div className="">
    
            <h1 className="">Hosts</h1>
        
            <Link to={ route('hosts.create') } className="">
                Add Host
            </Link>
        
            <div className="border-t h-[1px] my-6"></div>
        
            <div className="">
                { hosts.length > 0 && hosts.map(host => {
                return (
                    <div
                    key={ host.id }
                    className=""
                    >
                        <div className="">
                            <div className="">
                                { host.name }
                            </div>
                            <div className="">
                                { host.description }
                            </div>
                        </div>
                        <div className="flex gap-1">
                            <Link
                                to={ route('hosts.edit', { id: host.id }) }
                                className=""
                            >
                            Edit
                            </Link>
                            <button
                                type="button"
                                className=""
                                onClick={ async () => {
                                    await destroyHost(host)
                                    await getHosts()
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
 
export default HostsList
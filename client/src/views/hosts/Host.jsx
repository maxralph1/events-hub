import { useNavigate, useParams } from 'react-router-dom'
import { route } from '@/routes'
import { useHost } from '@/hooks/useHost'
 
function Host() {
    const params = useParams()
    const { host } = useHost(params.id)
    const navigate = useNavigate()
    
    return (
        <div className="">
    
            <h1 className="">Host <b>{ host.name }</b></h1>

            <p>Name: { host.name }</p>
    
            <p>Description: { host.description }</p>
    
            <div className="border-t h-[1px] my-6"></div>
    
            <div className="flex items-center gap-2">
                <button
                    type="button"
                    className=""
                    disabled={ host.loading }
                    onClick={ () => navigate(route('hosts.index')) }
                >Hosts
                </button>
            </div>
        </div>
    )
}
 
export default Host
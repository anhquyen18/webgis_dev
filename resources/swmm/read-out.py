from swmm_api import SwmmOutput
from swmm_api.output_file import *

import sys
import json

def main():
    out = SwmmOutput('F:/Water Resource/SWMM/tam_ky/swmm/tamky.out')
    listDepthOfJunction = out.get_part('node', 'J138', 'depth').to_frame().to_dict()['node/J138/depth']
    # listDepthOfJunction = out.get_part(OBJECTS.NODE, '4', VARIABLES.NODE.DEPTH).to_frame().to_json(orient='records')
    # lastValue = listDepthOfJunction[len(listDepthOfJunction)-1]

    converted_dict = {str(key): str(round(value,4)) for key, value in listDepthOfJunction.items()}

    return  json.dumps(converted_dict)





if __name__ == "__main__":
    print(main())
    # main()
    
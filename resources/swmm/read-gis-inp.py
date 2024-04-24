from swmm_api import read_out_file
from swmm_api import read_inp_file
from swmm_api.input_file.macros import *
from swmm_api.input_file.macros.gis import *
import sys
import json

def main():
    inp = read_inp_file('F:/Water Resource/SWMM/first-sample-project.inp')
    # set_crs(inp, 'EPSG:4326')
    subcatchment = subcatchment_geo_data_frame(inp).geometry['S1']
    subcatchmentCoords = list(subcatchment.exterior.coords)
    centroid = list(subcatchment.centroid.coords)[0]

    subcatchmentConnector = list(get_subcatchment_connectors(inp).geometry['S1'].coords)
    
    link = links_geo_data_frame(inp).geometry

    node = nodes_geo_data_frame(inp).geometry

    return subcatchmentCoords





if __name__ == "__main__":
    print(main())
    # main()
    
/** @type {import('tailwindcss').Config} */
export default {
	purge: ["./index.html", "./src/**/*.{vue,js}"],
	theme: {
		extend: {
			colors: {
				"primary-100": "#B2F7FF",
				"primary-200": "#4DEDFF",
				"primary-300": "#38DFF5",
				"primary-400": "#00CEE5",
				"primary-500": "#00AABD",
				//
				"secondary-100": "#264AF8",
				"secondary-200": "#0B29B8",
				"secondary-300": "#082191",
				"secondary-400": "#031772",
				"secondary-500": "#08144D",
				//
				"red-100": "#FF7166",
				"red-200": "#FF594D",
				"red-300": "#F54538",
				"red-400": "#F91706",
				"red-500": "#C2160A",
				//
				"green-100": "#D0FF80",
				"green-200": "#B3FA38",
				"green-300": "#6FAA09",
				"green-400": "#5D8E0B",
				"green-500": "#2F4904",
				//
				"yellow-100": "#FFEF79",
				"yellow-300": "#F5D800",
				"yellow-500": "#C8B315",
				//
				"gray-100": "#F1F1F1",
				"gray-200": "#E6E6E6",
				"gray-300": "#CCCCCC",
				"gray-400": "#B3B3B3",
				"gray-500": "#999999",
				"gray-600": "#737373",
				"gray-700": "#353535",
				"gray-800": "#333333",
				"gray-900": "#1B1B1B",
			},
			backgroundImage: {
				hero: "linear-gradient(0deg, rgba(0, 0, 0, 0.55), rgba(0, 0, 0, 0.55)), url('@/assets/img/hero.jpg')",
			},
		},
	},
	plugins: [],
};
